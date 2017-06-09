<?php

class MigrateController extends Controller
{
    public $layout = '2column_left';

    protected function beforeAction($action) {

        //increase the max execution time
        @ini_set('max_execution_time', -1);
        //memory_limit
        @ini_set('memory_limit', '-1');

        //initial needed session variables
        $migrated_data = array(
            'website_ids' => array(),
            'store_group_ids' => array(),
            'store_ids' => array(),
            'category_ids' => array(),
            'product_type_ids' => array(),
            'product_ids' => array(),
            'customer_group_ids' => array(),
            'customer_ids' => array(),
            'sales_object_ids' => array(),
            'sales_order_ids' => array(),
            'sales_quote_ids' => array(),
            'sales_invoice_ids' => array(),
            'sales_shipment_ids' => array(),
            'sales_credit_ids' => array(),
            //reviews/ratings
            'object_ids' => array(),
            'review_ids' => array(),
            'rating_ids' => array(),
            'other_object_ids' => array()
        );
        $migratedObj = (object) $migrated_data;
        //update migrated data
        //$steps = MigrateSteps::model()->findAll("status = " . MigrateSteps::STATUS_DONE);
        $steps = MigrateSteps::model()->findAll();
        if ($steps){
            foreach ($steps as $step) {
                $migrated_data = json_decode($step->migrated_data);
                if ($migrated_data) {
                    $attributes = get_object_vars($migrated_data);
                    if ($attributes){
                        foreach ($attributes as $attr => $value){
                            $migratedObj->$attr = $value;
                        }
                    }
                }
            }
        }

        $attributes = get_object_vars($migratedObj);
        if ($attributes){
            foreach ($attributes as $attr => $value){
                Yii::app()->session['migrated_'.$attr] = $value;
            }
        }
        //end initial needed session variables

        return parent::beforeAction($action);
    }

    /**
     * This method is invoked right after an action is executed.
     * You may override this method to do some postprocessing for the action.
     * @param CAction $action the action just executed.
     */
    protected function afterAction($action)
    {
        return parent::afterAction($action);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the index page
     */
    public function actionIndex()
    {
        $nextStep = MigrateSteps::getNextSteps();
        $this->redirect(array($nextStep));
    }

    /**
     * Database settings
     */
    public function actionStep1()
    {
        $step = MigrateSteps::model()->find("sorder = 1");
        if (Yii::app()->request->isPostRequest){

            $step->migrated_data = json_encode($_POST);

            //validate databases
            mysqli_report(MYSQLI_REPORT_STRICT);
            $err_msg = array();
            $validate = true;
            //validate magento1 database
            try {
                $port1 = (!empty($_POST['mg1_db_port'])) ? $_POST['mg1_db_port'] : ini_get("mysqli.default_port");
                $connection = mysqli_connect($_POST['mg1_host'], $_POST['mg1_db_user'], $_POST['mg1_db_pass'], $_POST['mg1_db_name'], $port1);
                if ($connection) {
                    //validate magento2 database
                    try {
                        $port2 = (!empty($_POST['mg2_db_port'])) ? $_POST['mg2_db_port'] : ini_get("mysqli.default_port");
                        $connection = mysqli_connect($_POST['mg2_host'], $_POST['mg2_db_user'], $_POST['mg2_db_pass'], $_POST['mg2_db_name'], $port2);
                    } catch (Exception $e ) {
                        $err_msg[] = Yii::t('frontend', "Couldn't connected to Magento 2 database: ".$e->getMessage());
                        $validate = false;
                    }
                }
            } catch ( Exception $e ) {
                $err_msg[] = Yii::t('frontend', "Couldn't connected to Magento 1 database: ".$e->getMessage());
                $validate = false;
            }
            if (isset($connection) AND $connection){
                mysqli_close($connection);
            }

            if ($validate){
                //save to config file
                $configTemplate = Yii::app()->basePath .DIRECTORY_SEPARATOR. "config".DIRECTORY_SEPARATOR."config.template";
                $configFilePath = Yii::app()->basePath .DIRECTORY_SEPARATOR. "config".DIRECTORY_SEPARATOR."config.php";
                if (file_exists($configTemplate)){
                    if (file_exists($configFilePath) && is_writable($configFilePath)){
                        $configs = file_get_contents($configTemplate);
                        //replace needed configs
                        $configs = str_replace('{MG1_HOST}', $_POST['mg1_host'], $configs);
                        $configs = str_replace('{MG1_DB_PORT}', $port1, $configs);
                        $configs = str_replace('{MG1_DB_NAME}', $_POST['mg1_db_name'], $configs);
                        $configs = str_replace('{MG1_DB_USER}', $_POST['mg1_db_user'], $configs);
                        $configs = str_replace('{MG1_DB_PASS}', $_POST['mg1_db_pass'], $configs);
                        $configs = str_replace('{MG1_DB_PREFIX}', $_POST['mg1_db_prefix'], $configs);
                        $configs = str_replace('{MG1_VERSION}', $_POST['mg1_version'], $configs);
                        //Mage2
                        $configs = str_replace('{MG2_HOST}', $_POST['mg2_host'], $configs);
                        $configs = str_replace('{MG2_DB_PORT}', $port2, $configs);
                        $configs = str_replace('{MG2_DB_NAME}', $_POST['mg2_db_name'], $configs);
                        $configs = str_replace('{MG2_DB_USER}', $_POST['mg2_db_user'], $configs);
                        $configs = str_replace('{MG2_DB_PASS}', $_POST['mg2_db_pass'], $configs);
                        $configs = str_replace('{MG2_DB_PREFIX}', $_POST['mg2_db_prefix'], $configs);

                        //save
                        if (file_put_contents($configFilePath, $configs)){
                            //save settings to database
                            $step->status = MigrateSteps::STATUS_DONE;
                            if ($step->save()) {
                                //alert message
                                Yii::app()->user->setFlash('success', Yii::t('frontend', "Your settings was saved successfully."));
                            }
                        }
                    }else{
                        Yii::app()->user->setFlash('note', Yii::t('frontend', "The config file was not exists or not ablewrite permission.<br/>Please make writeable for config file and try again."));
                    }
                }else{
                    Yii::app()->user->setFlash('note', Yii::t('frontend', "The config.template file was not exists."));
                }
            }else{
                Yii::app()->user->setFlash('error', implode('</br>', $err_msg));
            }
        } else {
            if ($step->status == MigrateSteps::STATUS_NOT_DONE) {

                //auto load database 2 settings if exists
                $configFilePath = Yii::app()->basePath ."/../../../app/etc/env.php";
                if (file_exists($configFilePath)){
                    $configData = require $configFilePath;
                    $settings = (object)json_decode($step->migrated_data);
                    $settings->mg2_host = (isset($configData['db']['connection']['default']['host'])) ? $configData['db']['connection']['default']['host'] : '';
                    $settings->mg2_db_user = (isset($configData['db']['connection']['default']['username'])) ? $configData['db']['connection']['default']['username'] : '';
                    $settings->mg2_db_pass = (isset($configData['db']['connection']['default']['password'])) ? $configData['db']['connection']['default']['password'] : '';
                    $settings->mg2_db_name = (isset($configData['db']['connection']['default']['dbname'])) ? $configData['db']['connection']['default']['dbname'] : '';
                    $settings->mg2_db_prefix = (isset($configData['db']['table_prefix'])) ? $configData['db']['table_prefix'] : '';
                }
            }
        }

        if (!isset($settings)){
            $settings = (object)json_decode($step->migrated_data);
        }

        $assign_data = array(
            'step' => $step,
            'settings' => $settings
        );
        $this->render("step{$step->sorder}", $assign_data);
    }

    /**
     * Migrate Websites & Store groups & Store views
     */
    public function actionStep2()
    {
        $step = MigrateSteps::model()->find("sorder = 2");
        $result = MigrateSteps::checkStep($step->sorder);
        if ($result['allowed']) {

            //variables to log
            $migrated_website_ids = $migrated_store_group_ids = $migrated_store_ids = array();

            //get list front-end websites from magento1 and exclude the admin website
            $condition = "code <> 'admin'";
            $websites = Mage1Website::model()->findAll($condition);

            if (Yii::app()->request->isPostRequest && $step->status == MigrateSteps::STATUS_NOT_DONE) {

                //un-check foreign key
                Yii::app()->mage2->createCommand("SET FOREIGN_KEY_CHECKS=0")->execute();

                //start migrate process
                $website_ids = Yii::app()->request->getParam('website_ids', array());
                $store_group_ids = Yii::app()->request->getParam('store_group_ids', array());
                $store_ids = Yii::app()->request->getParam('store_ids', array());
                $store_codes = $errors = array();

                // if has selected websites, store groups, stores
                if (sizeof($website_ids) > 0 AND sizeof($store_group_ids) > 0 AND sizeof($store_ids) > 0){

                    //delete default websites, stores, store views
                    Mage2Store::model()->deleteAll("code = 'default' AND website_id = 1");
                    Mage2StoreGroup::model()->deleteAll("website_id = 1");
                    Mage2Website::model()->deleteAll("code = 'base'");

                    //start migrate
                    foreach ($websites as $website) {
                        if (in_array($website->website_id, $website_ids)) {

                            $website2 = new Mage2Website();
                            $website2->website_id = $website->website_id;
                            $website2->code = $website->code;
                            $website2->name = $website->name;
                            $website2->sort_order = $website->sort_order;
                            $website2->default_group_id = $website->default_group_id;
                            $website2->is_default = $website->is_default;

                            if ($website2->save()) {
                                //update to log
                                $migrated_website_ids[] = $website->website_id;

                                if ($store_group_ids AND isset($store_group_ids[$website->website_id])) {
                                    //migrate store groups of this website
                                    $str_group_ids = implode(',', $store_group_ids[$website->website_id]);
                                    $condition = "website_id = {$website->website_id} AND group_id IN ({$str_group_ids})";
                                    $storeGroups = Mage1StoreGroup::model()->findAll($condition);
                                    if ($storeGroups) {
                                        foreach ($storeGroups as $storeGroup) {

                                            $storeGroup2 = new Mage2StoreGroup();
                                            $storeGroup2->group_id = $storeGroup->group_id;
                                            $storeGroup2->website_id = $storeGroup->website_id;
                                            $storeGroup2->name = $storeGroup->name;
                                            $storeGroup2->root_category_id = $storeGroup->root_category_id;
                                            $storeGroup2->default_store_id = $storeGroup->default_store_id;

                                            if ($storeGroup2->save()) {
                                                //update to log
                                                $migrated_store_group_ids[] = $storeGroup->group_id;

                                                if ($store_ids && isset($store_ids[$storeGroup->group_id])) {

                                                    //migrate stores of current store group
                                                    $str_store_ids = implode(',', $store_ids[$storeGroup->group_id]);
                                                    $condition = "website_id = {$website->website_id} AND store_id IN ({$str_store_ids})";
                                                    $stores = Mage1Store::model()->findAll($condition);
                                                    if ($stores) {
                                                        foreach ($stores as $store) {
                                                            $store2 = new Mage2Store();
                                                            $store2->store_id = $store->store_id;
                                                            $store2->code = $store->code;
                                                            $store2->website_id = $store->website_id;
                                                            $store2->group_id = $store->group_id;
                                                            $store2->name = $store->name;
                                                            $store2->sort_order = $store->sort_order;
                                                            $store2->is_active = $store->is_active;
                                                            if ($store2->save()) {
                                                                //update to log
                                                                $migrated_store_ids[] = $store->store_id;
                                                                $store_codes[] = $store->code;
                                                            } else {
                                                                $errors[] = get_class($store2).": ".MigrateSteps::getStringErrors($store2->getErrors());
                                                            }
                                                        }
                                                    }
                                                }
                                            } else {
                                                $errors[] = get_class($storeGroup2).": ".MigrateSteps::getStringErrors($storeGroup2->getErrors());
                                            }
                                        }
                                    }
                                }
                            } else {
                                $errors[] = get_class($website2).": ".MigrateSteps::getStringErrors($website2->getErrors());
                            }
                        }
                    }

                    //Update step status
                    if ($migrated_website_ids || $migrated_store_group_ids || $migrated_store_ids) {
                        $step->status = MigrateSteps::STATUS_DONE;

                        //add admin website id
                        array_push($migrated_website_ids, '0');
                        //add store group admin
                        array_push($migrated_store_group_ids, '0');
                        //add admin store id
                        array_push($migrated_store_ids, '0');

                        $migrated_data = array(
                            'website_ids' => $migrated_website_ids,
                            'store_group_ids' => $migrated_store_group_ids,
                            'store_ids' => $migrated_store_ids
                        );
                        $step->migrated_data = json_encode($migrated_data);

                        if ($step->update()) {
                            //Update session
                            Yii::app()->session['migrated_website_ids'] = $migrated_website_ids;
                            Yii::app()->session['migrated_store_group_ids'] = $migrated_store_group_ids;
                            Yii::app()->session['migrated_store_ids'] = $migrated_store_ids;

                            //check foreign key
                            Yii::app()->mage2->createCommand("SET FOREIGN_KEY_CHECKS=1")->execute();

                            //alert message
                            $message = "Migrated successfully. Total Website: %s1, Total Stores: %s2, Total Store Views: %s3";
                            $message = Yii::t('frontend', $message, array('%s1'=> (sizeof($migrated_website_ids)-1), '%s2'=> (sizeof($migrated_store_group_ids)-1), '%s3' => (sizeof($migrated_store_ids)-1) ));
                            Yii::app()->user->setFlash('success', $message);
                        }
                    }
                } else {
                    Yii::app()->user->setFlash('note', Yii::t('frontend', 'You have to select at least one website, one store group, one store to migrate.'));
                }

                //alert errors if exists
                if ($errors){
                    $strErrors = implode('<br/>', $errors);
                    Yii::app()->user->setFlash('error', $strErrors);
                }

            } else {
                if ($step->status == MigrateSteps::STATUS_DONE){
                    Yii::app()->user->setFlash('note', Yii::t('frontend', "This step was finished. If you want to update data of this step, the first you have to click to 'Reset' button."));
                }
            }

            $assign_data = array(
                'step' => $step,
                'websites' => $websites,
            );
            $this->render("step{$step->sorder}", $assign_data);
        }else{
            Yii::app()->user->setFlash('note', Yii::t('frontend', "The first you need to finish the %s.", array("%s" => ucfirst($result['back_step']))));
            $this->redirect(array($result['back_step']));
        }
    }

    /**
     * Migrate Attributes
     */
    public function actionStep3()
    {
        $step = MigrateSteps::model()->find("sorder = 3");
        $result = MigrateSteps::checkStep($step->sorder);
        if ($result['allowed']){

            //get migrated data of step1 from session
            $migrated_store_ids = isset(Yii::app()->session['migrated_store_ids']) ? Yii::app()->session['migrated_store_ids'] : array();

            $migrated_attribute_set_ids = $migrated_attribute_group_ids = $migrated_attribute_ids = array();

            //get product entity type id
            $product_entity_type_id = MigrateSteps::getMage1EntityTypeId(MigrateSteps::PRODUCT_TYPE_CODE);

            //get all product attribute sets in magento1
            $attribute_sets = Mage1AttributeSet::model()->findAll("entity_type_id = {$product_entity_type_id}");

            //condition to get all system product attributes
            //$condition = "entity_type_id = {$product_entity_type_id} AND is_user_defined = 0";

            //get all product attributes
            $attributes = Mage1Attribute::model()->findAll("entity_type_id = {$product_entity_type_id}");

            if (Yii::app()->request->isPostRequest AND ($step->status == MigrateSteps::STATUS_NOT_DONE || $step->status == MigrateSteps::STATUS_SKIPPING)) {

                //un-check foreign key
                Yii::app()->mage2->createCommand("SET FOREIGN_KEY_CHECKS=0")->execute();

                //migrate attribute sets
                //eav_attribute_set
                if ($attribute_sets) {
                    foreach ($attribute_sets as $attribute_set) {
                        $entity_type_id2 = MigrateSteps::_getMage2EntityTypeId($attribute_set->entity_type_id);
                        $condition = "entity_type_id = {$entity_type_id2} AND attribute_set_name = '{$attribute_set->attribute_set_name}'";
                        $attribute_set2 = Mage2AttributeSet::model()->find($condition);
                        if (!$attribute_set2) {
                            $attribute_set2 = new Mage2AttributeSet();
                            $attribute_set2->entity_type_id = MigrateSteps::_getMage2EntityTypeId($attribute_set->entity_type_id);
                            $attribute_set2->attribute_set_name = $attribute_set->attribute_set_name;
                            $attribute_set2->sort_order = $attribute_set->sort_order;
                        }

                        if ($attribute_set2->save()){
                            $migrated_attribute_set_ids[] = $attribute_set->attribute_set_id;
                        }

                        //get all attribute groups of current attribute set
                        $condition = "attribute_set_id = {$attribute_set->attribute_set_id}";
                        $attribute_groups = Mage1AttributeGroup::model()->findAll($condition);
                        if ($attribute_groups) {
                            foreach ($attribute_groups as $attribute_group) {
                                $attribute_set_id2 = MigrateSteps::getMage2AttributeSetId($attribute_group->attribute_set_id, MigrateSteps::PRODUCT_TYPE_CODE);
                                $condition = "attribute_set_id = {$attribute_set_id2} AND attribute_group_name = '{$attribute_group->attribute_group_name}'";
                                $attribute_group2 = Mage2AttributeGroup::model()->find($condition);
                                if (!$attribute_group2) {
                                    $attribute_group2 = new Mage2AttributeGroup();
                                    $attribute_group2->attribute_set_id = $attribute_set_id2;
                                    $attribute_group2->attribute_group_name = $attribute_group->attribute_group_name;
                                    $attribute_group2->sort_order = $attribute_group->sort_order;
                                    $attribute_group2->default_id = $attribute_group->default_id;
                                    //NOTE: this values is new added in Magento2, we will update after migrated in back-end of Magento2
                                    $attributeGroupCode = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($attribute_group->attribute_group_name)), '-');
                                    $attribute_group2->attribute_group_code = $attributeGroupCode;
                                    $attribute_group2->tab_group_code = null;
                                }
                                if ($attribute_group2->save()) {
                                    $migrated_attribute_group_ids[] = $attribute_group->attribute_group_id;
                                }
                            }
                        }
                    }
                }

                //migrate product attributes
                if ($attributes) {
                    //Some tables need to reset before migrate
                    Mage2AttributeOption::model()->deleteAll();
                    Mage2AttributeOptionValue::model()->deleteAll();

                    foreach ($attributes as $attribute) {

                        //msrp_enabled was changed to msrp in magento2
                        if ($attribute->attribute_code == 'msrp_enabled')
                            $attribute_code2 = 'msrp';
                        else
                            $attribute_code2 = $attribute->attribute_code;

                        $entity_type_id2 = MigrateSteps::_getMage2EntityTypeId($attribute->entity_type_id);
                        $condition = "entity_type_id = {$entity_type_id2} AND attribute_code = '{$attribute_code2}'";

                        $attribute2 = Mage2Attribute::model()->find($condition);
                        if (!$attribute2) {
                            $attribute2 = new Mage2Attribute();
                            foreach ($attribute2->attributes as $key => $value) {
                                if (isset($attribute->$key)) {
                                    $attribute2->$key = $attribute->$key;
                                }
                            }
                            //We need re-update some values
                            $attribute2->attribute_id = null;
                            $attribute2->entity_type_id = MigrateSteps::_getMage2EntityTypeId($attribute->entity_type_id);
                            $attribute2->attribute_model = null;
                            $attribute2->backend_model = null;
                            $attribute2->frontend_model = null;
                            $attribute2->source_model = null;
                        }

                        //save or update data of a attribute
                        if ($attribute2->save()) {
                            //update total
                            $migrated_attribute_ids[] = $attribute->attribute_id;

                            if ($migrated_store_ids) {
                                //eav_attribute_label
                                $condition = "attribute_id = {$attribute->attribute_id}";
                                $str_store_ids = implode(',', $migrated_store_ids);
                                $condition .= " AND store_id IN ({$str_store_ids})";
                                $attribute_labels = Mage1AttributeLabel::model()->findAll($condition);
                                if ($attribute_labels) {
                                    foreach ($attribute_labels as $attribute_label){
                                        $attribute_label2 = new Mage2AttributeLabel();
                                        $attribute_label2->attribute_label_id = $attribute_label->attribute_label_id;
                                        $attribute_label2->attribute_id = $attribute2->attribute_id;
                                        $attribute_label2->store_id = $attribute_label->store_id;
                                        $attribute_label2->value = $attribute_label->value;
                                        //save or update
                                        $attribute_label2->save();
                                    }
                                }
                            }

                            //eav_attribute_option
                            $attribute_options = Mage1AttributeOption::model()->findAll("attribute_id = {$attribute->attribute_id}");
                            if ($attribute_options){
                                foreach ($attribute_options as $attribute_option){

                                    $attribute_option2 = new Mage2AttributeOption();
                                    $attribute_option2->option_id = $attribute_option->option_id;
                                    $attribute_option2->attribute_id = $attribute2->attribute_id;
                                    $attribute_option2->sort_order = $attribute_option->sort_order;

                                    //save or update
                                    if ($attribute_option2->save()){
                                        //eav_attribute_option_value,
                                        if ($migrated_store_ids) {

                                            //get all option values of current option in Magento1
                                            $condition = "option_id = {$attribute_option->option_id}";
                                            $str_store_ids = implode(',', $migrated_store_ids);
                                            $condition .= " AND store_id IN ({$str_store_ids})";
                                            $option_values = Mage1AttributeOptionValue::model()->findAll($condition);

                                            if ($option_values){
                                                foreach ($option_values as $option_value) {

                                                    $option_value2 = new Mage2AttributeOptionValue();
                                                    $option_value2->value_id = $option_value->value_id;
                                                    $option_value2->option_id = $option_value->option_id;
                                                    $option_value2->store_id = $option_value->store_id;
                                                    $option_value2->value = $option_value->value;

                                                    //update or save
                                                    $option_value2->save();
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            //catalog_eav_attribute
                            $catalog_eav_attribute = Mage1CatalogEavAttribute::model()->find("attribute_id = {$attribute->attribute_id}");
                            if ($catalog_eav_attribute) {
                                $catalog_eav_attribute2 = Mage2CatalogEavAttribute::model()->find("attribute_id = {$attribute2->attribute_id}");
                                if (!$catalog_eav_attribute2) { //create new
                                    $catalog_eav_attribute2 = new Mage2CatalogEavAttribute();
                                    foreach ($catalog_eav_attribute2->attributes as $key => $value){
                                        if (isset($catalog_eav_attribute->$key)){
                                            $catalog_eav_attribute2->$key = $catalog_eav_attribute->$key;
                                        }
                                    }
                                    //update new attribute_id
                                    $catalog_eav_attribute2->attribute_id = $attribute2->attribute_id;
                                    $catalog_eav_attribute2->is_required_in_admin_store = 0;
                                    //this not take because was changed in magento2
                                    $catalog_eav_attribute2->frontend_input_renderer = null;
                                } else {
//                                    //update settings values
//                                    $catalog_eav_attribute2->is_global = $catalog_eav_attribute->is_global;
//                                    $catalog_eav_attribute2->is_visible = $catalog_eav_attribute->is_visible;
//                                    $catalog_eav_attribute2->is_searchable = $catalog_eav_attribute->is_searchable;
//                                    $catalog_eav_attribute2->is_filterable = $catalog_eav_attribute->is_filterable;
//                                    $catalog_eav_attribute2->is_comparable = $catalog_eav_attribute->is_comparable;
//                                    $catalog_eav_attribute2->is_visible_on_front = $catalog_eav_attribute->is_visible_on_front;
//                                    $catalog_eav_attribute2->is_html_allowed_on_front = $catalog_eav_attribute->is_html_allowed_on_front;
//                                    $catalog_eav_attribute2->is_filterable_in_search = $catalog_eav_attribute->is_filterable_in_search;
//                                    $catalog_eav_attribute2->used_in_product_listing = $catalog_eav_attribute->used_in_product_listing;
//                                    $catalog_eav_attribute2->used_for_sort_by = $catalog_eav_attribute->used_for_sort_by;
//                                    $catalog_eav_attribute2->apply_to = $catalog_eav_attribute->apply_to;
//                                    $catalog_eav_attribute2->is_visible_in_advanced_search = $catalog_eav_attribute->is_visible_in_advanced_search;
                                    $catalog_eav_attribute2->position = $catalog_eav_attribute->position;
                                    $catalog_eav_attribute2->is_wysiwyg_enabled = $catalog_eav_attribute->is_wysiwyg_enabled;
                                    $catalog_eav_attribute2->is_used_for_price_rules = $catalog_eav_attribute->is_used_for_price_rules;
                                    $catalog_eav_attribute2->is_used_for_promo_rules = $catalog_eav_attribute->is_used_for_promo_rules;
                                }

                                //save
                                $catalog_eav_attribute2->save();
                            }
                        }
                    }//end foreach attributes
                }

                //eav_entity_attribute
                //we only migrate related with products
                if ($migrated_attribute_set_ids && $migrated_attribute_group_ids && $migrated_attribute_ids) {
                    //make condition
                    $str_migrated_attribute_ids = implode(',', $migrated_attribute_ids);
                    $str_migrated_attribute_set_ids = implode(',', $migrated_attribute_set_ids);
                    $str_migrated_attribute_group_ids = implode(',', $migrated_attribute_group_ids);
                    $condition = "entity_type_id = {$product_entity_type_id} AND attribute_id IN ($str_migrated_attribute_ids)";
                    $condition .= " AND attribute_set_id IN ({$str_migrated_attribute_set_ids})";
                    $condition .= " AND attribute_group_id IN ({$str_migrated_attribute_group_ids})";
                    $entity_attributes = Mage1EntityAttribute::model()->findAll($condition);
                    if ($entity_attributes){
                        foreach ($entity_attributes as $entity_attribute){
                            $attribute_id2 = MigrateSteps::getMage2AttributeId($entity_attribute->attribute_id, '4');
                            $attribute_set_id2 = MigrateSteps::getMage2AttributeSetId($entity_attribute->attribute_set_id, MigrateSteps::PRODUCT_TYPE_CODE);
                            $attribute_group_id2 = MigrateSteps::getMage2AttributeGroupId($entity_attribute->attribute_group_id);

                            if ($attribute_id2 && $attribute_set_id2 && $attribute_group_id2){
                                $condition = "attribute_id = {$attribute_id2} AND entity_type_id = 4";
                                $condition .= " AND attribute_set_id = {$attribute_set_id2}";
                                $entity_attribute2 = Mage2EntityAttribute::model()->find($condition);
                                if (!$entity_attribute2) {
                                    $entity_attribute2 = new Mage2EntityAttribute();
                                    $entity_attribute2->entity_type_id = MigrateSteps::_getMage2EntityTypeId($entity_attribute->entity_type_id);
                                    $entity_attribute2->attribute_set_id = $attribute_set_id2;
                                    $entity_attribute2->attribute_group_id = $attribute_group_id2;
                                    $entity_attribute2->attribute_id = $attribute_id2;
                                    $entity_attribute2->sort_order = $entity_attribute->sort_order;
                                }
                                //save or update
                                $entity_attribute2->save();
                            }
                        }
                    }
                }

                //Update step status
                if ($migrated_attribute_set_ids && $migrated_attribute_group_ids && $migrated_attribute_ids){
                    $step->status = MigrateSteps::STATUS_DONE;
                    if ($step->update()) {

                        //check foreign key
                        Yii::app()->mage2->createCommand("SET FOREIGN_KEY_CHECKS=1")->execute();

                        $message = "Migrated successfully. Total Product Attribute Sets: %s1, Total Product Attribute Groups: %s2, Total Product Attributes: %s3";
                        $message = Yii::t('frontend', $message, array('%s1'=> sizeof($migrated_attribute_set_ids),
                                '%s2'=> sizeof($migrated_attribute_group_ids),
                                '%s3' => sizeof($migrated_attribute_ids))
                        );
                        Yii::app()->user->setFlash('success', $message);
                    }
                }
            }//end post request
            else{
                if ($step->status == MigrateSteps::STATUS_DONE){
                    Yii::app()->user->setFlash('note', Yii::t('frontend', "This step was finished. If you want to update data of this step, the first you have to click to 'Reset' button."));
                }
            }

            $assign_data = array(
                'step' => $step,
                'attribute_sets' => $attribute_sets,
                'attributes' => $attributes
            );
            $this->render("step{$step->sorder}", $assign_data);
        }else{
            Yii::app()->user->setFlash('note', Yii::t('frontend', "The first you need to finish the %s.", array("%s" => ucfirst($result['back_step']))));
            $this->redirect(array($result['back_step']));
        }
    }

    /**
     * Migrate Categories
     */
    public function actionStep4()
    {
        $step = MigrateSteps::model()->find("sorder = 4");
        $result = MigrateSteps::checkStep($step->sorder);
        if ($result['allowed']) {

            //variables to log
            $migrated_category_ids = array();

            //get migrated store_ids from session
            $migrated_store_ids = isset(Yii::app()->session['migrated_store_ids']) ? Yii::app()->session['migrated_store_ids'] : array();

            //get all categories from magento1
            $categories = Mage1CatalogCategoryEntity::model()->findAll();

            if (Yii::app()->request->isPostRequest AND ( $step->status == MigrateSteps::STATUS_NOT_DONE || $step->status == MigrateSteps::STATUS_SKIPPING)) {

                //un-check foreign key
                Yii::app()->mage2->createCommand("SET FOREIGN_KEY_CHECKS=0")->execute();

                /*
                 * Get black list attribute ids
                 * We do not migrate bellow attributes
                */
                $entity_type_id = MigrateSteps::getMage1EntityTypeId(MigrateSteps::CATEGORY_TYPE_CODE);
                $checkList = array(
                    MigrateSteps::getMage1AttributeId('display_mode', $entity_type_id) => 'PRODUCTS',
                    MigrateSteps::getMage1AttributeId('landing_page', $entity_type_id) => '',
                    MigrateSteps::getMage1AttributeId('custom_design', $entity_type_id) => '',
                    MigrateSteps::getMage1AttributeId('custom_design_from', $entity_type_id) => null,
                    MigrateSteps::getMage1AttributeId('custom_design_to', $entity_type_id) => null,
                    MigrateSteps::getMage1AttributeId('page_layout', $entity_type_id) => '',
                    MigrateSteps::getMage1AttributeId('custom_layout_update', $entity_type_id) => '',
                    MigrateSteps::getMage1AttributeId('custom_apply_to_products', $entity_type_id) => 1,
                    MigrateSteps::getMage1AttributeId('custom_use_parent_settings', $entity_type_id) => 1,
                );
                $keyCheckList = array_keys($checkList);

                //handle selected category ids
                $category_ids = Yii::app()->request->getPost('category_ids', array());
                $isCheckAll = Yii::app()->request->getPost('select_all_categories');

                //catalog_category_entity
                // if has selected category to migrate
                if ($isCheckAll || $category_ids) {
                    if ($categories){
                        foreach ($categories as $category){
                            if ( $isCheckAll || in_array($category->entity_id, $category_ids) ) {
                                $condition = "entity_id = {$category->entity_id}";
                                $category2 = Mage2CatalogCategoryEntity::model()->find($condition);
                                if (!$category2){
                                    $category2 = new Mage2CatalogCategoryEntity();
                                    $category2->entity_id = $category->entity_id;
                                    $category2->attribute_set_id = MigrateSteps::getMage2AttributeSetId($category->attribute_set_id, MigrateSteps::CATEGORY_TYPE_CODE);
                                    $category2->parent_id = $category->parent_id;
                                    $category2->created_at = $category->created_at;
                                    $category2->updated_at = $category->updated_at;
                                }
                                $category2->path = $category->path;
                                $category2->position = $category->position;
                                $category2->level = $category->level;
                                $category2->children_count = $category->children_count;

                                //update or save
                                if ($category2->save()){
                                    //update to log
                                    $migrated_category_ids[] = $category->entity_id;

                                    //catalog_category_entity_datetime
                                    $condition = "entity_id = {$category->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $models = Mage1CatalogCategoryEntityDatetime::model()->findAll($condition);
                                    if ($models){
                                        foreach ($models as $model){
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 3);
                                            if ($attribute_id2){
                                                $condition = "entity_id= {$model->entity_id} AND attribute_id = {$attribute_id2} AND store_id = {$model->store_id}";
                                                $model2 = Mage2CatalogCategoryEntityDatetime::model()->find($condition);
                                                if (!$model2){
                                                    $model2 = new Mage2CatalogCategoryEntityDatetime();
                                                    $model2->attribute_id = $attribute_id2;
                                                    $model2->store_id = $model->store_id;
                                                    $model2->entity_id = $model->entity_id;
                                                    //note: we need check and fixed for some attributes
                                                    if (in_array($model->attribute_id, $keyCheckList)){
                                                        $model2->value = $checkList[$model->attribute_id];
                                                    } else {
                                                        $model2->value = $model->value;
                                                    }
                                                    $model2->save();
                                                }
                                            }
                                        }
                                    }

                                    //catalog_category_entity_decimal
                                    $condition = "entity_id = {$category->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $models = Mage1CatalogCategoryEntityDecimal::model()->findAll($condition);
                                    if ($models){
                                        foreach ($models as $model) {
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 3);
                                            if ($attribute_id2){
                                                $condition = "entity_id= {$model->entity_id} AND attribute_id = {$attribute_id2} AND store_id = {$model->store_id}";
                                                $model2 = Mage2CatalogCategoryEntityDecimal::model()->find($condition);
                                                if (!$model2){
                                                    $model2 = new Mage2CatalogCategoryEntityDecimal();
                                                    $model2->attribute_id = $attribute_id2;
                                                    $model2->store_id = $model->store_id;
                                                    $model2->entity_id = $model->entity_id;
                                                    //we need check and fixed for some attributes
                                                    if (in_array($model->attribute_id, $keyCheckList)){
                                                        $model2->value = $checkList[$model->attribute_id];
                                                    } else {
                                                        $model2->value = $model->value;
                                                    }
                                                    $model2->save();
                                                }
                                            }
                                        }
                                    }

                                    //catalog_category_entity_int
                                    $condition = "entity_id = {$category->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $models = Mage1CatalogCategoryEntityInt::model()->findAll($condition);
                                    if ($models){
                                        foreach ($models as $model){
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 3);
                                            if ($attribute_id2){
                                                $condition = "entity_id= {$model->entity_id} AND attribute_id = {$attribute_id2} AND store_id = {$model->store_id}";
                                                $model2 = Mage2CatalogCategoryEntityInt::model()->find($condition);
                                                if (!$model2){
                                                    $model2 = new Mage2CatalogCategoryEntityInt();
                                                    $model2->attribute_id = $attribute_id2;
                                                    $model2->store_id = $model->store_id;
                                                    $model2->entity_id = $model->entity_id;
                                                    //note: we need check and fixed for some attributes
                                                    if (in_array($model->attribute_id, $keyCheckList)){
                                                        $model2->value = $checkList[$model->attribute_id];
                                                    } else {
                                                        $model2->value = $model->value;
                                                    }
                                                    $model2->save();
                                                }
                                            }
                                        }
                                    }

                                    //catalog_category_entity_text
                                    $condition = "entity_id = {$category->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $models = Mage1CatalogCategoryEntityText::model()->findAll($condition);
                                    if ($models){
                                        foreach ($models as $model){
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 3);
                                            if ($attribute_id2){
                                                $condition = "entity_id= {$model->entity_id} AND attribute_id = {$attribute_id2} AND store_id = {$model->store_id}";
                                                $model2 = Mage2CatalogCategoryEntityText::model()->find($condition);
                                                if (!$model2){
                                                    $model2 = new Mage2CatalogCategoryEntityText();
                                                    $model2->attribute_id = $attribute_id2;
                                                    $model2->store_id = $model->store_id;
                                                    $model2->entity_id = $model->entity_id;
                                                    //we need check and fixed for some attributes
                                                    if (in_array($model->attribute_id, $keyCheckList)){
                                                        $model2->value = $checkList[$model->attribute_id];
                                                    } else {
                                                        $model2->value = $model->value;
                                                    }
                                                    $model2->save();
                                                }
                                            }
                                        }
                                    }

                                    //catalog_category_entity_varchar
                                    $condition = "entity_id = {$category->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $models = Mage1CatalogCategoryEntityVarchar::model()->findAll($condition);
                                    if ($models){
                                        foreach ($models as $model){
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 3);
                                            if ($attribute_id2){
                                                $condition = "entity_id= {$model->entity_id} AND attribute_id = {$attribute_id2} AND store_id = {$model->store_id}";
                                                $model2 = Mage2CatalogCategoryEntityVarchar::model()->find($condition);
                                                if (!$model2){
                                                    $model2 = new Mage2CatalogCategoryEntityVarchar();
                                                    $model2->attribute_id = $attribute_id2;
                                                    $model2->store_id = $model->store_id;
                                                    $model2->entity_id = $model->entity_id;
                                                    //we need check and fixed for some attributes
                                                    if (in_array($model->attribute_id, $keyCheckList)){
                                                        $model2->value = $checkList[$model->attribute_id];
                                                    } else {
                                                        $model2->value = $model->value;
                                                    }
                                                    $model2->save();
                                                }
                                            }
                                        }
                                    }

                                    //url_rewrite for category
                                    $condition = "category_id = {$category->entity_id} AND product_id IS NULL";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $urls = Mage1UrlRewrite::model()->findAll($condition);
                                    if ($urls){
                                        foreach ($urls as $url){
                                            $condition = "store_id = {$url->store_id} AND entity_id = {$url->category_id} AND entity_type = 'category'";
                                            $url2 = Mage2UrlRewrite::model()->find($condition);
                                            if (!$url2) {
                                                $url2 = new Mage2UrlRewrite();
                                                $url2->entity_type = 'category';
                                                $url2->entity_id = $url->category_id;
                                                $url2->request_path = $url->request_path;
                                                $url2->target_path = $url->target_path;
                                                $url2->redirect_type = 0;
                                                $url2->store_id = $url->store_id;
                                                $url2->description = $url->description;
                                                $url2->is_autogenerated = $url->is_system;
                                                $url2->metadata = null;
                                                $url2->save();
                                            }
                                        }
                                    }
                                }// end save a category
                            }
                        }
                    }
                }else{
                    Yii::app()->user->setFlash('note', Yii::t('frontend', 'You have to select at least one Category to migrate.'));
                }

                //Update step status
                if ($migrated_category_ids){
                    $step->status = MigrateSteps::STATUS_DONE;
                    $step->migrated_data = json_encode(array(
                        'category_ids' => $migrated_category_ids
                    ));
                    if ($step->update()) {
                        //update session
                        Yii::app()->session['migrated_category_ids'] = $migrated_category_ids;

                        //check foreign key
                        Yii::app()->mage2->createCommand("SET FOREIGN_KEY_CHECKS=1")->execute();

                        $message = "Migrated successfully. Total Categories migrated: %s1";
                        $message = Yii::t('frontend', $message, array('%s1'=> sizeof($migrated_category_ids)));
                        Yii::app()->user->setFlash('success', $message);
                    }
                }
            }//end post request
            else{
                if ($step->status == MigrateSteps::STATUS_DONE){
                    Yii::app()->user->setFlash('note', Yii::t('frontend', "This step was finished. If you want to update data of this step, the first you have to click to 'Reset' button."));
                }
            }

            $assign_data = array(
                'step' => $step,
                'categories' => $categories
            );
            $this->render("step{$step->sorder}", $assign_data);
        }else{
            Yii::app()->user->setFlash('note', Yii::t('frontend', "The first you need to finish the %s.", array("%s" => ucfirst($result['back_step']))));
            $this->redirect(array($result['back_step']));
        }
    }

    /**
     * Migrate Products
     */
    public function actionStep5()
    {
        $step = MigrateSteps::model()->find("sorder = 5");
        $result = MigrateSteps::checkStep($step->sorder);
        if ($result['allowed']) {
            //get migrated website ids from session if has
            $migrated_website_ids = isset(Yii::app()->session['migrated_website_ids']) ? Yii::app()->session['migrated_website_ids'] : array();

            //get migrated store_ids from session
            $migrated_store_ids = isset(Yii::app()->session['migrated_store_ids']) ? Yii::app()->session['migrated_store_ids'] : array();

            //get migrated category ids
            $migrated_category_ids = isset(Yii::app()->session['migrated_category_ids']) ? Yii::app()->session['migrated_category_ids'] : array();

            //product types
            $product_type_ids = array('simple', 'configurable', 'grouped', 'virtual', 'bundle', 'downloadable');

            //variables to log
            $migrated_product_type_ids = array();
            $migrated_product_ids = array();
            $errors = array();

            if ( Yii::app()->request->isPostRequest AND ( $step->status == MigrateSteps::STATUS_NOT_DONE || $step->status == MigrateSteps::STATUS_SKIPPING) ) {

                //uncheck foreign key
                Yii::app()->mage2->createCommand("SET FOREIGN_KEY_CHECKS=0")->execute();

                /*
                 * Get black list attribute ids
                 * We do not migrate bellow attributes
                */
                $entity_type_id = MigrateSteps::getMage1EntityTypeId(MigrateSteps::PRODUCT_TYPE_CODE);
                $checkList = array(
                    MigrateSteps::getMage1AttributeId('custom_design', $entity_type_id) => '',
                    MigrateSteps::getMage1AttributeId('custom_design_from', $entity_type_id) => null,
                    MigrateSteps::getMage1AttributeId('custom_design_to', $entity_type_id) => null,
                    MigrateSteps::getMage1AttributeId('page_layout', $entity_type_id) => '',
                    MigrateSteps::getMage1AttributeId('custom_layout_update', $entity_type_id) => null,
                );
                $keyCheckList = array_keys($checkList);

                $selected_product_types = Yii::app()->request->getPost('product_type_ids', array());
                if ($selected_product_types) {
                    foreach ($selected_product_types as $type_id) {
                        // get products by type_id
                        //catalog_product_entity
                        $products = Mage1CatalogProductEntity::model()->findAll("type_id = '{$type_id}'");
                        if ($products){
                            foreach ($products as $product){

                                $product2 = new Mage2CatalogProductEntity();
                                foreach ($product2->attributes as $key => $value){
                                    if (isset($product->$key)){
                                        $product2->$key = $product->$key;
                                    }
                                }
                                $product2->attribute_set_id = MigrateSteps::getMage2AttributeSetId($product2->attribute_set_id, MigrateSteps::PRODUCT_TYPE_CODE);

                                //save or update
                                if ($product2->save()) {
                                    //update to log
                                    $migrated_product_ids[] = $product->entity_id;

                                    //catalog_product_entity_int
                                    $condition = "entity_id = {$product->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }

                                    $models = Mage1CatalogProductEntityInt::model()->findAll($condition);
                                    if ($models) {
                                        foreach ($models as $model) {
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 4);
                                            if ($attribute_id2){ // if exists
                                                $model2 = new Mage2CatalogProductEntityInt();
                                                $model2->attribute_id = $attribute_id2;
                                                $model2->store_id = $model->store_id;
                                                $model2->entity_id = $model->entity_id;
                                                //we need check and fixed for some attributes
                                                if (in_array($model->attribute_id, $keyCheckList)){
                                                    $model2->value = $checkList[$model->attribute_id];
                                                } else {
                                                    $model2->value = $model->value;
                                                }

                                                if (!$model2->save()) {
                                                    $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                                }
                                            }
                                        }
                                    }

                                    //catalog_product_entity_text
                                    $condition = "entity_id = {$product->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $models = Mage1CatalogProductEntityText::model()->findAll($condition);
                                    if ($models) {
                                        foreach ($models as $model) {
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 4);
                                            if ($attribute_id2){
                                                $model2 = new Mage2CatalogProductEntityText();
                                                $model2->attribute_id = $attribute_id2;
                                                $model2->store_id = $model->store_id;
                                                $model2->entity_id = $model->entity_id;
                                                //we need check and fixed for some attributes
                                                if (in_array($model->attribute_id, $keyCheckList)){
                                                    $model2->value = $checkList[$model->attribute_id];
                                                } else {
                                                    $model2->value = $model->value;
                                                }
                                                if (!$model2->save()) {
                                                    $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                                }
                                            }
                                        }
                                    }

                                    //catalog_product_entity_varchar
                                    $condition = "entity_id = {$product->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $models = Mage1CatalogProductEntityVarchar::model()->findAll($condition);
                                    if ($models){
                                        foreach ($models as $model){
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 4);
                                            if ($attribute_id2){
                                                $model2 = new Mage2CatalogProductEntityVarchar();
                                                $model2->attribute_id = $attribute_id2;
                                                $model2->store_id = $model->store_id;
                                                $model2->entity_id = $model->entity_id;
                                                //we need check and fixed for some attributes
                                                if (in_array($model->attribute_id, $keyCheckList)){
                                                    $model2->value = $checkList[$model->attribute_id];
                                                } else {
                                                    $model2->value = $model->value;
                                                }
                                                if (!$model2->save()) {
                                                    $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                                }
                                            }
                                        }
                                    }

                                    //catalog_product_entity_datetime
                                    $condition = "entity_id = {$product->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $models = Mage1CatalogProductEntityDatetime::model()->findAll($condition);
                                    if ($models){
                                        foreach ($models as $model) {
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 4);
                                            if ($attribute_id2){
                                                $model2 = new Mage2CatalogProductEntityDatetime();
                                                $model2->attribute_id = $attribute_id2;
                                                $model2->store_id = $model->store_id;
                                                $model2->entity_id = $model->entity_id;
                                                //we need check and fixed for some attributes
                                                if (in_array($model->attribute_id, $keyCheckList)){
                                                    $model2->value = $checkList[$model->attribute_id];
                                                } else {
                                                    $model2->value = $model->value;
                                                }
                                                if (!$model2->save()) {
                                                    $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                                }
                                            }
                                        }
                                    }

                                    //catalog_product_entity_decimal
                                    $condition = "entity_id = {$product->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $models = Mage1CatalogProductEntityDecimal::model()->findAll($condition);
                                    if ($models){
                                        foreach ($models as $model){
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 4);
                                            if ($attribute_id2){
                                                $model2 = new Mage2CatalogProductEntityDecimal();
                                                $model2->attribute_id = $attribute_id2;
                                                $model2->store_id = $model->store_id;
                                                $model2->entity_id = $model->entity_id;
                                                //we need check and fixed for some attributes
                                                if (in_array($model->attribute_id, $keyCheckList)){
                                                    $model2->value = $checkList[$model->attribute_id];
                                                } else {
                                                    $model2->value = $model->value;
                                                }
                                                if (!$model2->save()) {
                                                    $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                                }
                                            }
                                        }
                                    }

                                    //catalog_product_entity_gallery
                                    $condition = "entity_id = {$product->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $models = Mage1CatalogProductEntityGallery::model()->findAll($condition);
                                    if ($models){
                                        foreach ($models as $model) {
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 4);
                                            if ($attribute_id2){
                                                $model2 = new Mage2CatalogProductEntityGallery();
                                                $model2->attribute_id = $attribute_id2;
                                                $model2->store_id = $model->store_id;
                                                $model2->entity_id = $model->entity_id;
                                                $model2->position = $model->position;
                                                $model2->value = $model->value;
                                                if (!$model2->save()) {
                                                    $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                                }
                                            }
                                        }
                                    }

                                    //catalog_product_entity_media_gallery
                                    $condition = "entity_id = {$product->entity_id}";
                                    $models = Mage1CatalogProductEntityMediaGallery::model()->findAll($condition);
                                    if ($models){
                                        foreach ($models as $model){
                                            //we have to get correct attribute_id migrated
                                            $attribute_id2 = MigrateSteps::getMage2AttributeId($model->attribute_id, 4);
                                            if ($attribute_id2) {
                                                $model2 = new Mage2CatalogProductEntityMediaGallery();
                                                $model2->value_id = $model->value_id;
                                                $model2->attribute_id = $attribute_id2;
                                                //$model2->entity_id = $model->entity_id; //This field not use in CE 2.0.0
                                                $model2->value = $model->value;
                                                if ($model2->save()){
                                                    //catalog_product_entity_media_gallery_value
                                                    //we have migrate by migrated stores
                                                    if ($migrated_store_ids){
                                                        foreach ($migrated_store_ids as $store_id){
                                                            $gallery_value = Mage1CatalogProductEntityMediaGalleryValue::model()->find("value_id = {$model->value_id} AND store_id = {$store_id}");
                                                            if ($gallery_value){
                                                                $gallery_value2 = new Mage2CatalogProductEntityMediaGalleryValue();
                                                                $gallery_value2->value_id = $gallery_value->value_id;
                                                                $gallery_value2->store_id = $store_id;
                                                                $gallery_value2->entity_id = $model->entity_id;
                                                                $gallery_value2->label = $gallery_value->label;
                                                                $gallery_value2->position = $gallery_value->position;
                                                                $gallery_value2->disabled = $gallery_value->disabled;
                                                                $gallery_value2->save();
                                                            }
                                                        }
                                                    }
                                                    //catalog_product_entity_media_gallery_value_to_entity
                                                    $gallery_value_to_entity = new Mage2CatalogProductEntityMediaGalleryValueToEntity();
                                                    $gallery_value_to_entity->value_id = $model->value_id;
                                                    $gallery_value_to_entity->entity_id = $model->entity_id;
                                                    $gallery_value_to_entity->save();
                                                } else {
                                                    $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                                }
                                            }
                                        }
                                    }

                                    //catalog_product_option
                                    $condition = "product_id = {$product->entity_id}";
                                    $product_options = Mage1CatalogProductOption::model()->findAll($condition);
                                    if ($product_options){
                                        foreach ($product_options as $product_option){
                                            $product_option2 = new Mage2CatalogProductOption();
                                            foreach ($product_option2->attributes as $key => $value){
                                                if (isset($product_option->$key)){
                                                    $product_option2->$key = $product_option->$key;
                                                }
                                            }
                                            if ($product_option2->save()) {

                                                //catalog_product_option_type_value
                                                $condition = "option_id = {$product_option->option_id}";
                                                $option_type_values = Mage1CatalogProductOptionTypeValue::model()->findAll($condition);
                                                if ($option_type_values) {
                                                    foreach ($option_type_values as $option_type_value){
                                                        $option_type_value2 = new Mage2CatalogProductOptionTypeValue();
                                                        foreach ($option_type_value2->attributes as $key => $value){
                                                            if (isset($option_type_value->$key)){
                                                                $option_type_value2->$key = $option_type_value->$key;
                                                            }
                                                        }

                                                        if ($option_type_value2->save()) {
                                                            //catalog_product_option_type_price & catalog_product_option_type_title
                                                            if ($migrated_store_ids) {
                                                                foreach ($migrated_store_ids as $store_id) {
                                                                    //catalog_product_option_type_price
                                                                    $condition = "option_type_id = {$option_type_value->option_type_id} AND store_id = {$store_id}";
                                                                    $option_type_price = Mage1CatalogProductOptionTypePrice::model()->find($condition);
                                                                    if ($option_type_price){
                                                                        $option_type_price2 = new Mage2CatalogProductOptionTypePrice();
                                                                        foreach ($option_type_price2->attributes as $key => $value){
                                                                            if (isset($option_type_price->$key)){
                                                                                $option_type_price2->$key = $option_type_price->$key;
                                                                            }
                                                                        }
                                                                        $option_type_price2->store_id = $store_id;

                                                                        if (!$option_type_price2->save()) {
                                                                            $errors[] = get_class($option_type_price2).": ".MigrateSteps::getStringErrors($option_type_price2->getErrors());
                                                                        }
                                                                    }

                                                                    //catalog_product_option_type_title
                                                                    $condition = "option_type_id = {$option_type_value->option_type_id} AND store_id = {$store_id}";
                                                                    $option_type_title = Mage1CatalogProductOptionTypeTitle::model()->find($condition);
                                                                    if ($option_type_title){
                                                                        $option_type_title2 = new Mage2CatalogProductOptionTypeTitle();
                                                                        foreach ($option_type_title2->attributes as $key => $value){
                                                                            if (isset($option_type_title->$key)){
                                                                                $option_type_title2->$key = $option_type_title->$key;
                                                                            }
                                                                        }
                                                                        $option_type_title2->store_id = $store_id;

                                                                        if (!$option_type_title2->save()) {
                                                                            $errors[] = get_class($option_type_title2).": ".MigrateSteps::getStringErrors($option_type_title2->getErrors());
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                //we have to migrate by migrated stores
                                                if ($migrated_store_ids) {
                                                    foreach ($migrated_store_ids as $store_id) {
                                                        //catalog_product_option_price
                                                        $option_price = Mage1CatalogProductOptionPrice::model()->find("option_id = {$product_option->option_id} AND store_id = {$store_id}");
                                                        if ($option_price) {
                                                            $option_price2 = new Mage2CatalogProductOptionPrice();
                                                            foreach ($option_price2->attributes as $key => $value){
                                                                if (isset($option_price->$key)){
                                                                    $option_price2->$key = $option_price->$key;
                                                                }
                                                            }
                                                            $option_price2->store_id = $store_id;

                                                            if (!$option_price2->save()) {
                                                                $errors[] = get_class($option_price2).": ".MigrateSteps::getStringErrors($option_price2->getErrors());
                                                            }
                                                        }

                                                        //catalog_product_option_title
                                                        $option_title = Mage1CatalogProductOptionTitle::model()->find("option_id = {$product_option->option_id} AND store_id = {$store_id}");
                                                        if ($option_title){
                                                            $option_title2 = new Mage2CatalogProductOptionTitle();
                                                            foreach ($option_title2->attributes as $key => $value) {
                                                                if (isset($option_title->$key)){
                                                                    $option_title2->$key = $option_title->$key;
                                                                }
                                                            }
                                                            $option_title2->store_id = $store_id;

                                                            if (!$option_title2->save()) {
                                                                $errors[] = get_class($option_title2).": ".MigrateSteps::getStringErrors($option_title2->getErrors());
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    //cataloginventory_stock_status
                                    if ($migrated_website_ids) {
                                        foreach ($migrated_website_ids as $website_id) {
                                            $models = Mage1StockStatus::model()->findAll("website_id = {$website_id} AND product_id = {$product->entity_id}");
                                            if ($models){
                                                foreach ($models as $model) {
                                                    $model2 = new Mage2StockStatus();
                                                    foreach ($model2->attributes as $key => $value){
                                                        if (isset($model->$key)){
                                                            $model2->$key = $model->$key;
                                                        }
                                                    }
                                                    if ($model2->save()) {
                                                        //cataloginventory_stock_item
                                                        $stock_item2 = Mage2StockItem::model()->find("product_id = {$model->product_id} AND stock_id = {$model->stock_id}");
                                                        if (!$stock_item2){
                                                            $stock_item = Mage1StockItem::model()->find("product_id = {$model->product_id} AND stock_id = {$model->stock_id}");
                                                            if ($stock_item){
                                                                $stock_item2 = new Mage2StockItem();
                                                                foreach ($stock_item2->attributes as $key => $value){
                                                                    if ($key != 'item_id' && isset($stock_item->$key)){
                                                                        $stock_item2->$key = $stock_item->$key;
                                                                    }
                                                                }
                                                                //this field is new in Magento 2
                                                                $stock_item2->website_id = $website_id;

                                                                if (!$stock_item2->save()) {
                                                                    $errors[] = get_class($stock_item2).": ".MigrateSteps::getStringErrors($stock_item2->getErrors());
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    //url_rewrite
                                    $condition = "product_id = {$product->entity_id}";
                                    if ($migrated_store_ids) {
                                        $str_store_ids = implode(',', $migrated_store_ids);
                                        $condition .= " AND store_id IN ({$str_store_ids})";
                                    }
                                    $urls = Mage1UrlRewrite::model()->findAll($condition);
                                    if ($urls) {
                                        foreach ($urls as $url) {
                                            $url2 = new Mage2UrlRewrite();
                                            $url2->entity_type = 'product';
                                            $url2->entity_id = $url->product_id;
                                            $url2->request_path = $url->request_path;
                                            $url2->target_path = $url->target_path;
                                            $url2->redirect_type = 0;
                                            $url2->store_id = $url->store_id;
                                            $url2->description = $url->description;
                                            $url2->is_autogenerated = $url->is_system;
                                            if ($url->category_id)
                                                $url2->metadata = serialize(array('category_id'=>$url->category_id));
                                            else
                                                $url2->metadata = null;
                                            if ($url2->save()) {
                                                //catalog_url_rewrite_product_category
                                                $catalog_url2 = new Mage2CatalogUrlRewriteProductCategory();
                                                $catalog_url2->url_rewrite_id = $url2->url_rewrite_id;
                                                $catalog_url2->category_id = $url->category_id;
                                                $catalog_url2->product_id = $url->product_id;
                                                $catalog_url2->save();
                                            }
                                        }
                                    }
                                }//end save a product
                            }// endforeach products

                        }// endif has products

                        //update to log
                        $migrated_product_type_ids[] = $type_id;
                    }//end foreach product types

                    //Start migrate related data with a product
                    if ($migrated_product_ids) {

                        //make string product ids
                        $str_product_ids = implode(',', $migrated_product_ids);

                        //catalog_product_website
                        if ($migrated_website_ids){
                            $str_website_ids = implode(',', $migrated_website_ids);
                            $condition = "product_id IN ({$str_product_ids}) AND website_id IN ({$str_website_ids})";
                            $models = Mage1CatalogProductWebsite::model()->findAll($condition);
                            if ($models){
                                foreach ($models as $model){
                                    $model2 = new Mage2CatalogProductWebsite();
                                    $model2->product_id = $model->product_id;
                                    $model2->website_id = $model->website_id;

                                    if (!$model2->save()) {
                                        $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                    }
                                }
                            }
                        }

                        //catalog_category_product
                        if ($migrated_category_ids) {
                            foreach ($migrated_category_ids as $category_id) {
                                $condition = "product_id IN ({$str_product_ids}) AND category_id = {$category_id}";
                                $models = Mage1CatalogCategoryProduct::model()->findAll($condition);
                                if ($models) {
                                    foreach ($models as $model) {
                                        $model2 = new Mage2CatalogCategoryProduct();
                                        $model2->category_id = $model->category_id;
                                        $model2->product_id = $model->product_id;
                                        $model2->position = $model->position;

                                        if (!$model2->save()) {
                                            $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                        }
                                    }
                                }
                            }
                        }

                        //Cross sell, Up sell, Related & Grouped Products
                        /** catalog_product_link_type:
                         * 1 - relation - Related Products
                         * 3 - super - Grouped Products
                         * 4 - up_sell - Up Sell Products
                         * 5 - cross_sell - Cross Sell Products
                         *
                         * Note: Tables: catalog_product_link_type & catalog_product_link_attribute was not changed.
                         * So, we don't migrate these tables. But careful with id was changed in catalog_product_link_attribute
                         */
                        //link type ids to migration

                        //catalog_product_link
                        $link_type_ids = array(1, 4, 5);
                        if (in_array('grouped', $migrated_product_type_ids)){
                            $link_type_ids[] = 3;
                        }
                        $str_link_type_ids = implode(',', $link_type_ids);
                        $condition = "product_id IN ({$str_product_ids}) AND linked_product_id IN ({$str_product_ids}) AND link_type_id IN ({$str_link_type_ids})";
                        $models = Mage1CatalogProductLink::model()->findAll($condition);
                        if ($models){
                            foreach ($models as $model){
                                $model2 = new Mage2CatalogProductLink();
                                $model2->link_id = $model->link_id;
                                $model2->product_id = $model->product_id;
                                $model2->linked_product_id = $model->linked_product_id;
                                $model2->link_type_id = $model->link_type_id;
                                if ($model2->save()){
                                    //catalog_product_link_attribute_decimal
                                    $condition = "link_id = {$model2->link_id}";
                                    $items = Mage1CatalogProductLinkAttributeDecimal::model()->findAll($condition);
                                    if ($items){
                                        foreach ($items as $item){
                                            $item2 = new Mage2CatalogProductLinkAttributeDecimal();
                                            $item2->value_id = $item->value_id;
                                            $item2->product_link_attribute_id = MigrateSteps::getMage2ProductLinkAttrId($item->product_link_attribute_id);
                                            $item2->link_id = $item->link_id;
                                            $item2->value = $item->value;

                                            if (!$item2->save()) {
                                                $errors[] = get_class($item2).": ".MigrateSteps::getStringErrors($item2->getErrors());
                                            }
                                        }
                                    }
                                    //catalog_product_link_attribute_int
                                    $condition = "link_id = {$model2->link_id}";
                                    $items = Mage1CatalogProductLinkAttributeInt::model()->findAll($condition);
                                    if ($items){
                                        foreach ($items as $item){
                                            $item2 = new Mage2CatalogProductLinkAttributeInt();
                                            $item2->value_id = $item->value_id;
                                            $item2->product_link_attribute_id = MigrateSteps::getMage2ProductLinkAttrId($item->product_link_attribute_id);
                                            $item2->link_id = $item->link_id;
                                            $item2->value = $item->value;

                                            if (!$item2->save()) {
                                                $errors[] = get_class($item2).": ".MigrateSteps::getStringErrors($item2->getErrors());
                                            }
                                        }
                                    }
                                    //catalog_product_link_attribute_varchar
                                    $condition = "link_id = {$model2->link_id}";
                                    $items = Mage1CatalogProductLinkAttributeVarchar::model()->findAll($condition);
                                    if ($items){
                                        foreach ($items as $item){
                                            $item2 = new Mage2CatalogProductLinkAttributeVarchar();
                                            $item2->value_id = $item->value_id;
                                            $item2->product_link_attribute_id = MigrateSteps::getMage2ProductLinkAttrId($item->product_link_attribute_id);
                                            $item2->link_id = $item->link_id;
                                            $item2->value = $item->value;

                                            if (!$item2->save()) {
                                                $errors[] = get_class($item2).": ".MigrateSteps::getStringErrors($item2->getErrors());
                                            }
                                        }
                                    }
                                }
                            }
                        } //End Cross sell, Up sell, Related & Grouped Products

                        //Configurable products
                        if (in_array('configurable', $migrated_product_type_ids)){
                            //catalog_product_super_link
                            $condition = "product_id IN ({$str_product_ids}) AND parent_id IN ({$str_product_ids})";
                            $models = Mage1CatalogProductSuperLink::model()->findAll($condition);
                            if ($models) {
                                foreach ($models as $model) {
                                    $model2 = new Mage2CatalogProductSuperLink();
                                    $model2->link_id = $model->link_id;
                                    $model2->product_id = $model->product_id;
                                    $model2->parent_id = $model->parent_id;

                                    if (!$model2->save()) {
                                        $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                    }
                                }
                            }

                            //catalog_product_relation
                            $condition = "parent_id IN ({$str_product_ids}) AND child_id IN ({$str_product_ids})";
                            $models = Mage1CatalogProductRelation::model()->findAll($condition);
                            if ($models){
                                foreach ($models as $model){
                                    $model2 = new Mage2CatalogProductRelation();
                                    $model2->parent_id = $model->parent_id;
                                    $model2->child_id = $model->child_id;

                                    if (!$model2->save()) {
                                        $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                    }
                                }
                            }

                            //catalog_product_super_attribute
                            $condition = "product_id IN ({$str_product_ids})";
                            $models = Mage1CatalogProductSuperAttribute::model()->findAll($condition);
                            if ($models) {
                                foreach ($models as $model){
                                    $model2 = new Mage2CatalogProductSuperAttribute();
                                    $model2->product_super_attribute_id = $model->product_super_attribute_id;
                                    $model2->product_id = $model->product_id;
                                    $model2->attribute_id = MigrateSteps::getMage2AttributeId($model->attribute_id, 4);
                                    $model2->position = $model->position;
                                    if ($model2->save()) {
                                        //catalog_product_super_attribute_label
                                        $condition = "product_super_attribute_id = {$model2->product_super_attribute_id}";
                                        if ($migrated_store_ids) {
                                            $str_store_ids = implode(',', $migrated_store_ids);
                                            $condition .= " AND store_id IN ({$str_store_ids})";
                                        }
                                        $super_attribute_labels = Mage1CatalogProductSuperAttributeLabel::model()->findAll($condition);
                                        if ($super_attribute_labels) {
                                            foreach ($super_attribute_labels as $super_attribute_label) {
                                                $super_attribute_label2 = new Mage2CatalogProductSuperAttributeLabel();
                                                $super_attribute_label2->value_id = $super_attribute_label->value_id;
                                                $super_attribute_label2->product_super_attribute_id = $super_attribute_label->product_super_attribute_id;
                                                $super_attribute_label2->store_id = $super_attribute_label->store_id;
                                                $super_attribute_label2->use_default = $super_attribute_label->use_default;
                                                $super_attribute_label2->value = $super_attribute_label->value;

                                                if (!$super_attribute_label2->save()) {
                                                    $errors[] = get_class($super_attribute_label2).": ".MigrateSteps::getStringErrors($super_attribute_label2->getErrors());
                                                }
                                            }
                                        }
                                    } else {
                                        $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                    }
                                }
                            }
                        }//End Configurable products

                        //Bundle products
                        if (in_array('bundle', $migrated_product_type_ids)){
                            //catalog_product_bundle_option
                            $condition = "parent_id IN ({$str_product_ids})";
                            $models = Mage1CatalogProductBundleOption::model()->findAll($condition);
                            if ($models){
                                foreach ($models as $model){
                                    $model2 = new Mage2CatalogProductBundleOption();
                                    $model2->option_id = $model->option_id;
                                    $model2->parent_id = $model->parent_id;
                                    $model2->required = $model->required;
                                    $model2->position = $model->position;
                                    $model2->type = $model->type;
                                    if ($model2->save()) {
                                        //catalog_product_bundle_option_value
                                        $condition = "option_id = {$model2->option_id}";
                                        if ($migrated_store_ids) {
                                            $str_store_ids = implode(',', $migrated_store_ids);
                                            $condition .= " AND store_id IN ({$str_store_ids})";
                                        }
                                        $bundle_option_values = Mage1CatalogProductBundleOptionValue::model()->findAll($condition);
                                        if ($bundle_option_values){
                                            foreach ($bundle_option_values as $bundle_option_value) {
                                                $bundle_option_value2 = new Mage2CatalogProductBundleOptionValue();
                                                $bundle_option_value2->value_id = $bundle_option_value->value_id;
                                                $bundle_option_value2->option_id = $bundle_option_value->option_id;
                                                $bundle_option_value2->store_id = $bundle_option_value->store_id;
                                                $bundle_option_value2->title = $bundle_option_value->title;

                                                if (!$bundle_option_value2->save()) {
                                                    $errors[] = get_class($bundle_option_value2).": ".MigrateSteps::getStringErrors($bundle_option_value2->getErrors());
                                                }
                                            }
                                        }
                                        //catalog_product_bundle_selection
                                        $condition = "option_id = {$model2->option_id} AND product_id IN ({$str_product_ids})";
                                        $bundle_selections = Mage1CatalogProductBundleSelection::model()->findAll($condition);
                                        if ($bundle_selections){
                                            foreach ($bundle_selections as $bundle_selection){
                                                $bundle_selection2 = new Mage2CatalogProductBundleSelection();
                                                $bundle_selection2->selection_id = $bundle_selection->selection_id;
                                                $bundle_selection2->option_id = $bundle_selection->option_id;
                                                $bundle_selection2->parent_product_id = $bundle_selection->parent_product_id;
                                                $bundle_selection2->product_id = $bundle_selection->product_id;
                                                $bundle_selection2->position = $bundle_selection->position;
                                                $bundle_selection2->is_default = $bundle_selection->is_default;
                                                $bundle_selection2->selection_price_type = $bundle_selection->selection_price_type;
                                                $bundle_selection2->selection_price_value = $bundle_selection->selection_price_value;
                                                $bundle_selection2->selection_qty = $bundle_selection->selection_qty;
                                                $bundle_selection2->selection_can_change_qty = $bundle_selection->selection_can_change_qty;
                                                if ($bundle_selection2->save()) {
                                                    if ($migrated_website_ids){
                                                        $str_website_ids = implode(',', $migrated_website_ids);
                                                        //catalog_product_bundle_selection_price
                                                        $condition = "selection_id = {$bundle_selection2->selection_id} AND website_id IN ({$str_website_ids})";
                                                        $selection_prices = Mage1CatalogProductBundleSelectionPrice::model()->findAll($condition);
                                                        if ($selection_prices) {
                                                            foreach ($selection_prices as $selection_price){
                                                                $selection_price2 = new Mage2CatalogProductBundleSelectionPrice();
                                                                $selection_price2->selection_id = $selection_price->selection_id;
                                                                $selection_price2->website_id = $selection_price->website_id;
                                                                $selection_price2->selection_price_type = $selection_price->selection_price_type;
                                                                $selection_price2->selection_price_value = $selection_price->selection_price_value;

                                                                if (!$selection_price2->save()) {
                                                                    $errors[] = get_class($selection_price2).": ".MigrateSteps::getStringErrors($selection_price2->getErrors());
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    $errors[] = get_class($bundle_selection2).": ".MigrateSteps::getStringErrors($bundle_selection2->getErrors());
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }//End Bundle products

                        //Downloadable products
                        if (in_array('downloadable', $migrated_product_type_ids)){
                            //downloadable_link
                            $condition = "product_id IN ({$str_product_ids})";
                            $models = Mage1DownloadableLink::model()->findAll($condition);
                            if ($models){
                                foreach ($models as $model){
                                    $model2 = new Mage2DownloadableLink();
                                    foreach ($model2->attributes as $key => $value){
                                        if (isset($model->$key)){
                                            $model2->$key = $model->$key;
                                        }
                                    }
                                    if ($model2->save()) {
                                        if ($migrated_website_ids){
                                            //downloadable_link_price
                                            $str_website_ids = implode(',', $migrated_website_ids);
                                            $condition = "link_id = {$model2->link_id} AND website_id IN ({$str_website_ids})";
                                            $link_prices = Mage1DownloadableLinkPrice::model()->findAll($condition);
                                            if ($link_prices){
                                                foreach ($link_prices as $link_price){
                                                    $link_price2 = new Mage2DownloadableLinkPrice();
                                                    $link_price2->price_id = $link_price->price_id;
                                                    $link_price2->link_id = $link_price->link_id;
                                                    $link_price2->website_id = $link_price->website_id;
                                                    $link_price2->price = $link_price->price;

                                                    if (!$link_price2->save()) {
                                                        $errors[] = get_class($link_price2).": ".MigrateSteps::getStringErrors($link_price2->getErrors());
                                                    }
                                                }
                                            }
                                            //downloadable_link_title
                                            if ($migrated_store_ids) {
                                                $str_store_ids = implode(',', $migrated_store_ids);
                                                $condition = "link_id = {$model2->link_id} AND store_id IN ({$str_store_ids})";
                                                $link_titles = Mage1DownloadableLinkTitle::model()->findAll($condition);
                                                if ($link_titles) {
                                                    foreach ($link_titles as $link_title){
                                                        $link_title2 = new Mage2DownloadableLinkTitle();
                                                        $link_title2->title_id = $link_title->title_id;
                                                        $link_title2->link_id = $link_title->link_id;
                                                        $link_title2->store_id = $link_title->store_id;
                                                        $link_title2->title = $link_title->title;

                                                        if (!$link_title2->save()) {
                                                            $errors[] = get_class($link_title2).": ".MigrateSteps::getStringErrors($link_title2->getErrors());
                                                        }
                                                    }
                                                }
                                            }
                                            //downloadable_sample
                                            //downloadable_sample_title
                                        }
                                    } else {
                                        $errors[] = get_class($model2).": ".MigrateSteps::getStringErrors($model2->getErrors());
                                    }
                                }
                            }
                        } //End Downloadable products

                    }//End migrate related data with a product
                }else{
                    Yii::app()->user->setFlash('note', Yii::t('frontend', 'You have to select at least one Product type to migrate.'));
                }

                //Update step status
                if ($migrated_product_type_ids) {
                    $step->status = MigrateSteps::STATUS_DONE;
                    $step->migrated_data = json_encode(array(
                        'product_type_ids' => $migrated_product_type_ids,
                        'product_ids' => $migrated_product_ids
                    ));
                    if ($step->update()) {
                        //Update session
                        Yii::app()->session['migrated_product_type_ids'] = $migrated_product_type_ids;
                        Yii::app()->session['migrated_product_ids'] = $migrated_product_ids;

                        //check foreign key
                        Yii::app()->mage2->createCommand("SET FOREIGN_KEY_CHECKS=1")->execute();

                        $message = "Migrated successfully. Total Products migrated: %s1";
                        $message = Yii::t('frontend', $message, array('%s1'=> sizeof($migrated_product_ids)));
                        Yii::app()->user->setFlash('success', $message);
                    }
                }

                //alert errors if exists
                if ($errors){
                    $strErrors = implode('<br/>', $errors);
                    Yii::app()->user->setFlash('error', $strErrors);
                }
            }//end post request
            else{
                if ($step->status == MigrateSteps::STATUS_DONE){
                    Yii::app()->user->setFlash('note', Yii::t('frontend', "This step was finished. If you want to update data of this step, the first you have to click to 'Reset' button."));
                }
            }

            $assign_data = array(
                'step' => $step,
                'product_type_ids' => $product_type_ids
            );
            $this->render("step{$step->sorder}", $assign_data);
        }else{
            Yii::app()->user->setFlash('note', Yii::t('frontend', "The first you need to finish the %s.", array("%s" => ucfirst($result['back_step']))));
            $this->redirect(array($result['back_step']));
        }
    }

    public function actionStep6() {
        $this->redirect(Yii::app()->createUrl('migrate/upgrade', array('step_index' => 6)));
    }
    public function actionStep7() {
        $this->redirect(Yii::app()->createUrl('migrate/upgrade', array('step_index' => 7)));
    }
    public function actionStep8() {
        $this->redirect(Yii::app()->createUrl('migrate/upgrade', array('step_index' => 8)));
    }
    public function actionStep9() {
        $this->redirect(Yii::app()->createUrl('migrate/upgrade', array('step_index' => 9)));
    }
    public function actionUpgrade($step_index) {
        $step = MigrateSteps::model()->find("sorder = {$step_index}");
        $this->render('upgrade', array('step' => $step));
    }

    /**
     * Reset Database of magento2
     */
    public function actionResetAll() {
        $dataPath = Yii::app()->basePath .DIRECTORY_SEPARATOR. "data".DIRECTORY_SEPARATOR;
        $steps = MigrateSteps::model()->findAll();
        if ($steps){
            foreach ($steps as $step){
                //only for step1
                if($step->sorder == 1){
                    $step->status = MigrateSteps::STATUS_NOT_DONE;
                    $step->migrated_data = null;
                    $step->update();
                }

                //other steps
                $resetSQLFile = $dataPath . "step{$step->sorder}_reset.sql";
                if (file_exists($resetSQLFile)) {
                    $rs = MigrateSteps::executeFile($resetSQLFile);
                    if ($rs){
                        $step->status = MigrateSteps::STATUS_NOT_DONE;
                        $step->migrated_data = null;
                        $step->update();
                    }
                }
            }

            //delete url related data in url_rewrite table and catalog_url_rewrite_product_category table
            Mage2UrlRewrite::model()->deleteAll("entity_type = 'category'");

            //delete url related data in url_rewrite table and catalog_url_rewrite_product_category table
            Mage2UrlRewrite::model()->deleteAll("entity_type = 'product'");

            //flush cached
            Yii::app()->cache->flush();

            Yii::app()->user->setFlash('success', Yii::t('frontend', "Reset all successfully."));
            //Redirect to next step
            $nextStep = MigrateSteps::getNextSteps();
            $this->redirect(array($nextStep));
        }
    }

    public function actionReset() {
        $stepIndex = Yii::app()->request->getParam('step', 1);
        $step = MigrateSteps::model()->findByPk($stepIndex);
        if ($step) {
            $dataPath = Yii::app()->basePath .DIRECTORY_SEPARATOR. "data".DIRECTORY_SEPARATOR;
            $resetSQLFile = $dataPath . "step{$stepIndex}_reset.sql";
            if (file_exists($resetSQLFile)) {
                $rs = MigrateSteps::executeFile($resetSQLFile);
                if ($rs) {
                    if ($stepIndex == 4) {
                        //delete url related data in url_rewrite table and catalog_url_rewrite_product_category table
                        Mage2UrlRewrite::model()->deleteAll("entity_type = 'category'");
                    }
                    if ($stepIndex == 5) {
                        //delete url related data in url_rewrite table and catalog_url_rewrite_product_category table
                        Mage2UrlRewrite::model()->deleteAll("entity_type = 'product'");
                    }
                    //reset step status
                    $step->status = MigrateSteps::STATUS_NOT_DONE;
                    $step->migrated_data = null;
                    $step->update();

                    Yii::app()->user->setFlash('success', Yii::t('frontend', "Step #%s was reset successfully.", array('%s' => $stepIndex)));

                    //flush cached
                    Yii::app()->cache->flush();
                }
            }
        } else {
            Yii::app()->user->setFlash('note', Yii::t('frontend', "Step #%s not found.", array('%s' => $stepIndex)));
            $stepIndex = 1;
        }

        $this->redirect(array("step{$stepIndex}"));
    }

}
