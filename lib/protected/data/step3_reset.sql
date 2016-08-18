
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `#__eav_attribute`;
CREATE TABLE `#__eav_attribute` (
  `attribute_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Attribute Id',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type Id',
  `attribute_code` varchar(255) DEFAULT NULL COMMENT 'Attribute Code',
  `attribute_model` varchar(255) DEFAULT NULL COMMENT 'Attribute Model',
  `backend_model` varchar(255) DEFAULT NULL COMMENT 'Backend Model',
  `backend_type` varchar(8) NOT NULL DEFAULT 'static' COMMENT 'Backend Type',
  `backend_table` varchar(255) DEFAULT NULL COMMENT 'Backend Table',
  `frontend_model` varchar(255) DEFAULT NULL COMMENT 'Frontend Model',
  `frontend_input` varchar(50) DEFAULT NULL COMMENT 'Frontend Input',
  `frontend_label` varchar(255) DEFAULT NULL COMMENT 'Frontend Label',
  `frontend_class` varchar(255) DEFAULT NULL COMMENT 'Frontend Class',
  `source_model` varchar(255) DEFAULT NULL COMMENT 'Source Model',
  `is_required` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Defines Is Required',
  `is_user_defined` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Defines Is User Defined',
  `default_value` text COMMENT 'Default Value',
  `is_unique` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Defines Is Unique',
  `note` varchar(255) DEFAULT NULL COMMENT 'Note',
  PRIMARY KEY (`attribute_id`),
  UNIQUE KEY `EAV_ATTRIBUTE_ENTITY_TYPE_ID_ATTRIBUTE_CODE` (`entity_type_id`,`attribute_code`),
  CONSTRAINT `EAV_ATTRIBUTE_ENTITY_TYPE_ID_EAV_ENTITY_TYPE_ENTITY_TYPE_ID` FOREIGN KEY (`entity_type_id`) REFERENCES `#__eav_entity_type` (`entity_type_id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Eav Attribute' AUTO_INCREMENT=135;

INSERT INTO `#__eav_attribute` VALUES(1, 1, 'website_id', NULL, 'Magento\\Customer\\Model\\Customer\\Attribute\\Backend\\Website', 'static', NULL, NULL, 'select', 'Associate to Website', NULL, 'Magento\\Customer\\Model\\Customer\\Attribute\\Source\\Website', 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(2, 1, 'store_id', NULL, 'Magento\\Customer\\Model\\Customer\\Attribute\\Backend\\Store', 'static', NULL, NULL, 'select', 'Create In', NULL, 'Magento\\Customer\\Model\\Customer\\Attribute\\Source\\Store', 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(3, 1, 'created_in', NULL, NULL, 'static', NULL, NULL, 'text', 'Created From', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(4, 1, 'prefix', NULL, NULL, 'static', NULL, NULL, 'text', 'Prefix', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(5, 1, 'firstname', NULL, NULL, 'static', NULL, NULL, 'text', 'First Name', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(6, 1, 'middlename', NULL, NULL, 'static', NULL, NULL, 'text', 'Middle Name/Initial', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(7, 1, 'lastname', NULL, NULL, 'static', NULL, NULL, 'text', 'Last Name', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(8, 1, 'suffix', NULL, NULL, 'static', NULL, NULL, 'text', 'Suffix', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(9, 1, 'email', NULL, NULL, 'static', NULL, NULL, 'text', 'Email', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(10, 1, 'group_id', NULL, NULL, 'static', NULL, NULL, 'select', 'Group', NULL, 'Magento\\Customer\\Model\\Customer\\Attribute\\Source\\Group', 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(11, 1, 'dob', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Backend\\Datetime', 'static', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Frontend\\Datetime', 'date', 'Date of Birth', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(12, 1, 'password_hash', NULL, 'Magento\\Customer\\Model\\Customer\\Attribute\\Backend\\Password', 'static', NULL, NULL, 'hidden', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(13, 1, 'rp_token', NULL, NULL, 'static', NULL, NULL, 'hidden', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(14, 1, 'rp_token_created_at', NULL, NULL, 'static', NULL, NULL, 'date', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(15, 1, 'default_billing', NULL, 'Magento\\Customer\\Model\\Customer\\Attribute\\Backend\\Billing', 'static', NULL, NULL, 'text', 'Default Billing Address', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(16, 1, 'default_shipping', NULL, 'Magento\\Customer\\Model\\Customer\\Attribute\\Backend\\Shipping', 'static', NULL, NULL, 'text', 'Default Shipping Address', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(17, 1, 'taxvat', NULL, NULL, 'static', NULL, NULL, 'text', 'Tax/VAT Number', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(18, 1, 'confirmation', NULL, NULL, 'static', NULL, NULL, 'text', 'Is Confirmed', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(19, 1, 'created_at', NULL, NULL, 'static', NULL, NULL, 'date', 'Created At', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(20, 1, 'gender', NULL, NULL, 'static', NULL, NULL, 'select', 'Gender', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Source\\Table', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(21, 1, 'disable_auto_group_change', NULL, 'Magento\\Customer\\Model\\Attribute\\Backend\\Data\\Boolean', 'static', NULL, NULL, 'boolean', 'Disable Automatic Group Change Based on VAT ID', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(22, 2, 'prefix', NULL, NULL, 'static', NULL, NULL, 'text', 'Prefix', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(23, 2, 'firstname', NULL, NULL, 'static', NULL, NULL, 'text', 'First Name', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(24, 2, 'middlename', NULL, NULL, 'static', NULL, NULL, 'text', 'Middle Name/Initial', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(25, 2, 'lastname', NULL, NULL, 'static', NULL, NULL, 'text', 'Last Name', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(26, 2, 'suffix', NULL, NULL, 'static', NULL, NULL, 'text', 'Suffix', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(27, 2, 'company', NULL, NULL, 'static', NULL, NULL, 'text', 'Company', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(28, 2, 'street', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Backend\\DefaultBackend', 'static', NULL, NULL, 'multiline', 'Street Address', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(29, 2, 'city', NULL, NULL, 'static', NULL, NULL, 'text', 'City', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(30, 2, 'country_id', NULL, NULL, 'static', NULL, NULL, 'select', 'Country', NULL, 'Magento\\Customer\\Model\\ResourceModel\\Address\\Attribute\\Source\\Country', 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(31, 2, 'region', NULL, 'Magento\\Customer\\Model\\ResourceModel\\Address\\Attribute\\Backend\\Region', 'static', NULL, NULL, 'text', 'State/Province', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(32, 2, 'region_id', NULL, NULL, 'static', NULL, NULL, 'hidden', 'State/Province', NULL, 'Magento\\Customer\\Model\\ResourceModel\\Address\\Attribute\\Source\\Region', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(33, 2, 'postcode', NULL, NULL, 'static', NULL, NULL, 'text', 'Zip/Postal Code', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(34, 2, 'telephone', NULL, NULL, 'static', NULL, NULL, 'text', 'Phone Number', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(35, 2, 'fax', NULL, NULL, 'static', NULL, NULL, 'text', 'Fax', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(36, 2, 'vat_id', NULL, NULL, 'static', NULL, NULL, 'text', 'VAT number', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(37, 2, 'vat_is_valid', NULL, NULL, 'static', NULL, NULL, 'text', 'VAT number validity', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(38, 2, 'vat_request_id', NULL, NULL, 'static', NULL, NULL, 'text', 'VAT number validation request ID', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(39, 2, 'vat_request_date', NULL, NULL, 'static', NULL, NULL, 'text', 'VAT number validation request date', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(40, 2, 'vat_request_success', NULL, NULL, 'static', NULL, NULL, 'text', 'VAT number validation request success', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(41, 1, 'updated_at', NULL, NULL, 'static', NULL, NULL, 'date', 'Updated At', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(42, 1, 'failures_num', NULL, NULL, 'static', NULL, NULL, 'hidden', 'Failures Number', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(43, 1, 'first_failure', NULL, NULL, 'static', NULL, NULL, 'date', 'First Failure Date', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(44, 1, 'lock_expires', NULL, NULL, 'static', NULL, NULL, 'date', 'Failures Number', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(45, 3, 'name', NULL, NULL, 'varchar', NULL, NULL, 'text', 'Name', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(46, 3, 'is_active', NULL, NULL, 'int', NULL, NULL, 'select', 'Is Active', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Source\\Boolean', 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(47, 3, 'description', NULL, NULL, 'text', NULL, NULL, 'textarea', 'Description', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(48, 3, 'image', NULL, 'Magento\\Catalog\\Model\\Category\\Attribute\\Backend\\Image', 'varchar', NULL, NULL, 'image', 'Image', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(49, 3, 'meta_title', NULL, NULL, 'varchar', NULL, NULL, 'text', 'Page Title', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(50, 3, 'meta_keywords', NULL, NULL, 'text', NULL, NULL, 'textarea', 'Meta Keywords', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(51, 3, 'meta_description', NULL, NULL, 'text', NULL, NULL, 'textarea', 'Meta Description', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(52, 3, 'display_mode', NULL, NULL, 'varchar', NULL, NULL, 'select', 'Display Mode', NULL, 'Magento\\Catalog\\Model\\Category\\Attribute\\Source\\Mode', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(53, 3, 'landing_page', NULL, NULL, 'int', NULL, NULL, 'select', 'CMS Block', NULL, 'Magento\\Catalog\\Model\\Category\\Attribute\\Source\\Page', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(54, 3, 'is_anchor', NULL, NULL, 'int', NULL, NULL, 'select', 'Is Anchor', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Source\\Boolean', 0, 0, '1', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(55, 3, 'path', NULL, NULL, 'static', NULL, NULL, 'text', 'Path', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(56, 3, 'position', NULL, NULL, 'static', NULL, NULL, 'text', 'Position', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(57, 3, 'all_children', NULL, NULL, 'text', NULL, NULL, 'text', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(58, 3, 'path_in_store', NULL, NULL, 'text', NULL, NULL, 'text', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(59, 3, 'children', NULL, NULL, 'text', NULL, NULL, 'text', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(60, 3, 'custom_design', NULL, NULL, 'varchar', NULL, NULL, 'select', 'Custom Design', NULL, 'Magento\\Theme\\Model\\Theme\\Source\\Theme', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(61, 3, 'custom_design_from', 'Magento\\Catalog\\Model\\ResourceModel\\Eav\\Attribute', 'Magento\\Catalog\\Model\\Attribute\\Backend\\Startdate', 'datetime', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Frontend\\Datetime', 'date', 'Active From', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(62, 3, 'custom_design_to', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Backend\\Datetime', 'datetime', NULL, NULL, 'date', 'Active To', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(63, 3, 'page_layout', NULL, NULL, 'varchar', NULL, NULL, 'select', 'Page Layout', NULL, 'Magento\\Catalog\\Model\\Category\\Attribute\\Source\\Layout', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(64, 3, 'custom_layout_update', NULL, 'Magento\\Catalog\\Model\\Attribute\\Backend\\Customlayoutupdate', 'text', NULL, NULL, 'textarea', 'Custom Layout Update', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(65, 3, 'level', NULL, NULL, 'static', NULL, NULL, 'text', 'Level', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(66, 3, 'children_count', NULL, NULL, 'static', NULL, NULL, 'text', 'Children Count', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(67, 3, 'available_sort_by', NULL, 'Magento\\Catalog\\Model\\Category\\Attribute\\Backend\\Sortby', 'text', NULL, NULL, 'multiselect', 'Available Product Listing Sort By', NULL, 'Magento\\Catalog\\Model\\Category\\Attribute\\Source\\Sortby', 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(68, 3, 'default_sort_by', NULL, 'Magento\\Catalog\\Model\\Category\\Attribute\\Backend\\Sortby', 'varchar', NULL, NULL, 'select', 'Default Product Listing Sort By', NULL, 'Magento\\Catalog\\Model\\Category\\Attribute\\Source\\Sortby', 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(69, 3, 'include_in_menu', NULL, NULL, 'int', NULL, NULL, 'select', 'Include in Navigation Menu', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Source\\Boolean', 1, 0, '1', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(70, 3, 'custom_use_parent_settings', NULL, NULL, 'int', NULL, NULL, 'select', 'Use Parent Category Settings', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Source\\Boolean', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(71, 3, 'custom_apply_to_products', NULL, NULL, 'int', NULL, NULL, 'select', 'Apply To Products', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Source\\Boolean', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(72, 3, 'filter_price_range', NULL, NULL, 'decimal', NULL, NULL, 'text', 'Layered Navigation Price Step', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(73, 4, 'name', NULL, NULL, 'varchar', NULL, NULL, 'text', 'Product Name', 'validate-length maximum-length-255', NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(74, 4, 'sku', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Sku', 'static', NULL, NULL, 'text', 'SKU', 'validate-length maximum-length-64', NULL, 1, 0, NULL, 1, NULL);
INSERT INTO `#__eav_attribute` VALUES(75, 4, 'description', NULL, NULL, 'text', NULL, NULL, 'textarea', 'Description', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(76, 4, 'short_description', NULL, NULL, 'text', NULL, NULL, 'textarea', 'Short Description', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(77, 4, 'price', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Price', 'decimal', NULL, NULL, 'price', 'Price', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(78, 4, 'special_price', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Price', 'decimal', NULL, NULL, 'price', 'Special Price', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(79, 4, 'special_from_date', NULL, 'Magento\\Catalog\\Model\\Attribute\\Backend\\Startdate', 'datetime', NULL, NULL, 'date', 'Special Price From Date', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(80, 4, 'special_to_date', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Backend\\Datetime', 'datetime', NULL, NULL, 'date', 'Special Price To Date', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(81, 4, 'cost', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Price', 'decimal', NULL, NULL, 'price', 'Cost', NULL, NULL, 0, 1, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(82, 4, 'weight', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Weight', 'decimal', NULL, NULL, 'weight', 'Weight', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(83, 4, 'manufacturer', NULL, NULL, 'int', NULL, NULL, 'select', 'Manufacturer', NULL, NULL, 0, 1, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(84, 4, 'meta_title', NULL, NULL, 'varchar', NULL, NULL, 'text', 'Meta Title', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(85, 4, 'meta_keyword', NULL, NULL, 'text', NULL, NULL, 'textarea', 'Meta Keywords', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(86, 4, 'meta_description', NULL, NULL, 'varchar', NULL, NULL, 'textarea', 'Meta Description', NULL, NULL, 0, 0, NULL, 0, 'Maximum 255 chars. Meta Description should optimally be between 150-160 characters');
INSERT INTO `#__eav_attribute` VALUES(87, 4, 'image', NULL, NULL, 'varchar', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Frontend\\Image', 'media_image', 'Base', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(88, 4, 'small_image', NULL, NULL, 'varchar', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Frontend\\Image', 'media_image', 'Small', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(89, 4, 'thumbnail', NULL, NULL, 'varchar', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Frontend\\Image', 'media_image', 'Thumbnail', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(90, 4, 'media_gallery', NULL, NULL, 'static', NULL, NULL, 'gallery', 'Media Gallery', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(91, 4, 'old_id', NULL, NULL, 'int', NULL, NULL, 'text', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(92, 4, 'tier_price', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Tierprice', 'decimal', NULL, NULL, 'text', 'Tier Price', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(93, 4, 'color', NULL, NULL, 'int', NULL, NULL, 'select', 'Color', NULL, NULL, 0, 1, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(94, 4, 'news_from_date', NULL, 'Magento\\Catalog\\Model\\Attribute\\Backend\\Startdate', 'datetime', NULL, NULL, 'date', 'Set Product as New from Date', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(95, 4, 'news_to_date', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Backend\\Datetime', 'datetime', NULL, NULL, 'date', 'Set Product as New to Date', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(96, 4, 'gallery', NULL, NULL, 'varchar', NULL, NULL, 'gallery', 'Image Gallery', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(97, 4, 'status', NULL, NULL, 'int', NULL, NULL, 'select', 'Enable Product', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Source\\Status', 0, 0, '1', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(98, 4, 'minimal_price', NULL, NULL, 'decimal', NULL, NULL, 'price', 'Minimal Price', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(99, 4, 'visibility', NULL, NULL, 'int', NULL, NULL, 'select', 'Visibility', NULL, 'Magento\\Catalog\\Model\\Product\\Visibility', 0, 0, '4', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(100, 4, 'custom_design', NULL, NULL, 'varchar', NULL, NULL, 'select', 'New Theme', NULL, 'Magento\\Theme\\Model\\Theme\\Source\\Theme', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(101, 4, 'custom_design_from', NULL, 'Magento\\Catalog\\Model\\Attribute\\Backend\\Startdate', 'datetime', NULL, NULL, 'date', 'Active From', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(102, 4, 'custom_design_to', NULL, 'Magento\\Eav\\Model\\Entity\\Attribute\\Backend\\Datetime', 'datetime', NULL, NULL, 'date', 'Active To', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(103, 4, 'custom_layout_update', NULL, 'Magento\\Catalog\\Model\\Attribute\\Backend\\Customlayoutupdate', 'text', NULL, NULL, 'textarea', 'Layout Update XML', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(104, 4, 'page_layout', NULL, NULL, 'varchar', NULL, NULL, 'select', 'Layout', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Source\\Layout', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(105, 4, 'category_ids', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Category', 'static', NULL, NULL, 'text', 'Categories', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(106, 4, 'options_container', NULL, NULL, 'varchar', NULL, NULL, 'select', 'Display Product Options In', NULL, 'Magento\\Catalog\\Model\\Entity\\Product\\Attribute\\Design\\Options\\Container', 0, 0, 'container2', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(107, 4, 'required_options', NULL, NULL, 'static', NULL, NULL, 'text', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(108, 4, 'has_options', NULL, NULL, 'static', NULL, NULL, 'text', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(109, 4, 'image_label', NULL, NULL, 'varchar', NULL, NULL, 'text', 'Image Label', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(110, 4, 'small_image_label', NULL, NULL, 'varchar', NULL, NULL, 'text', 'Small Image Label', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(111, 4, 'thumbnail_label', NULL, NULL, 'varchar', NULL, NULL, 'text', 'Thumbnail Label', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(112, 4, 'created_at', NULL, NULL, 'static', NULL, NULL, 'date', NULL, NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(113, 4, 'updated_at', NULL, NULL, 'static', NULL, NULL, 'date', NULL, NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(114, 4, 'country_of_manufacture', NULL, NULL, 'varchar', NULL, NULL, 'select', 'Country of Manufacture', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Source\\Countryofmanufacture', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(115, 4, 'quantity_and_stock_status', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Stock', 'int', NULL, NULL, 'select', 'Quantity', NULL, 'Magento\\CatalogInventory\\Model\\Source\\Stock', 0, 0, '1', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(116, 4, 'custom_layout', NULL, NULL, 'varchar', NULL, NULL, 'select', 'New Layout', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Source\\Layout', 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(117, 3, 'url_key', NULL, NULL, 'varchar', NULL, NULL, 'text', 'URL Key', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(118, 3, 'url_path', NULL, NULL, 'varchar', NULL, NULL, 'text', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(119, 4, 'url_key', NULL, NULL, 'varchar', NULL, NULL, 'text', 'URL Key', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(120, 4, 'url_path', NULL, NULL, 'varchar', NULL, NULL, 'text', NULL, NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(121, 4, 'msrp', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Price', 'decimal', NULL, NULL, 'price', 'Manufacturer''s Suggested Retail Price', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(122, 4, 'msrp_display_actual_price_type', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Boolean', 'varchar', NULL, NULL, 'select', 'Display Actual Price', NULL, 'Magento\\Msrp\\Model\\Product\\Attribute\\Source\\Type\\Price', 0, 0, '0', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(123, 4, 'price_type', NULL, NULL, 'int', NULL, NULL, 'boolean', 'Dynamic Price', NULL, NULL, 1, 0, '0', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(124, 4, 'sku_type', NULL, NULL, 'int', NULL, NULL, 'boolean', 'Dynamic SKU', NULL, NULL, 1, 0, '0', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(125, 4, 'weight_type', NULL, NULL, 'int', NULL, NULL, 'boolean', 'Dynamic Weight', NULL, NULL, 1, 0, '0', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(126, 4, 'price_view', NULL, NULL, 'int', NULL, NULL, 'select', 'Price View', NULL, 'Magento\\Bundle\\Model\\Product\\Attribute\\Source\\Price\\View', 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(127, 4, 'shipment_type', NULL, NULL, 'int', NULL, NULL, 'select', 'Ship Bundle Items', NULL, 'Magento\\Bundle\\Model\\Product\\Attribute\\Source\\Shipment\\Type', 1, 0, '0', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(128, 4, 'links_purchased_separately', NULL, NULL, 'int', NULL, NULL, NULL, 'Links can be purchased separately', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(129, 4, 'samples_title', NULL, NULL, 'varchar', NULL, NULL, NULL, 'Samples title', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(130, 4, 'links_title', NULL, NULL, 'varchar', NULL, NULL, NULL, 'Links title', NULL, NULL, 1, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(131, 4, 'links_exist', NULL, NULL, 'int', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(132, 4, 'swatch_image', NULL, NULL, 'varchar', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Frontend\\Image', 'media_image', 'Swatch', NULL, NULL, 0, 0, NULL, 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(133, 4, 'tax_class_id', NULL, NULL, 'int', NULL, NULL, 'select', 'Tax Class', NULL, 'Magento\\Tax\\Model\\TaxClass\\Source\\Product', 0, 0, '2', 0, NULL);
INSERT INTO `#__eav_attribute` VALUES(134, 4, 'gift_message_available', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Backend\\Boolean', 'varchar', NULL, NULL, 'select', 'Allow Gift Message', NULL, 'Magento\\Catalog\\Model\\Product\\Attribute\\Source\\Boolean', 0, 0, NULL, 0, NULL);

DROP TABLE IF EXISTS `#__eav_attribute_group`;
CREATE TABLE `#__eav_attribute_group` (
  `attribute_group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Attribute Group Id',
  `attribute_set_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Set Id',
  `attribute_group_name` varchar(255) DEFAULT NULL COMMENT 'Attribute Group Name',
  `sort_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Sort Order',
  `default_id` smallint(5) unsigned DEFAULT '0' COMMENT 'Default Id',
  `attribute_group_code` varchar(255) NOT NULL COMMENT 'Attribute Group Code',
  `tab_group_code` varchar(255) DEFAULT NULL COMMENT 'Tab Group Code',
  PRIMARY KEY (`attribute_group_id`),
  UNIQUE KEY `EAV_ATTRIBUTE_GROUP_ATTRIBUTE_SET_ID_ATTRIBUTE_GROUP_NAME` (`attribute_set_id`,`attribute_group_name`),
  KEY `EAV_ATTRIBUTE_GROUP_ATTRIBUTE_SET_ID_SORT_ORDER` (`attribute_set_id`,`sort_order`),
  CONSTRAINT `EAV_ATTR_GROUP_ATTR_SET_ID_EAV_ATTR_SET_ATTR_SET_ID` FOREIGN KEY (`attribute_set_id`) REFERENCES `#__eav_attribute_set` (`attribute_set_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='Eav Attribute Group';

INSERT INTO `#__eav_attribute_group` VALUES(1, 1, 'General', 1, 1, 'general', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(2, 2, 'General', 1, 1, 'general', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(3, 3, 'General', 10, 1, 'general', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(4, 3, 'General Information', 2, 0, 'general-information', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(5, 3, 'Display Settings', 20, 0, 'display-settings', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(6, 3, 'Custom Design', 30, 0, 'custom-design', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(7, 4, 'Product Details', 10, 1, 'product-details', 'basic');
INSERT INTO `#__eav_attribute_group` VALUES(8, 4, 'Advanced Pricing', 40, 0, 'advanced-pricing', 'advanced');
INSERT INTO `#__eav_attribute_group` VALUES(9, 4, 'Search Engine Optimization', 30, 0, 'search-engine-optimization', 'basic');
INSERT INTO `#__eav_attribute_group` VALUES(10, 4, 'Images', 20, 0, 'image-management', 'basic');
INSERT INTO `#__eav_attribute_group` VALUES(11, 4, 'Design', 50, 0, 'design', 'advanced');
INSERT INTO `#__eav_attribute_group` VALUES(12, 4, 'Autosettings', 60, 0, 'autosettings', 'advanced');
INSERT INTO `#__eav_attribute_group` VALUES(13, 4, 'Content', 15, 0, 'content', 'basic');
INSERT INTO `#__eav_attribute_group` VALUES(14, 4, 'Schedule Design Update', 55, 0, 'schedule-design-update', 'advanced');
INSERT INTO `#__eav_attribute_group` VALUES(15, 4, 'Bundle Items', 16, 0, 'bundle-items', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(16, 5, 'General', 1, 1, 'general', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(17, 6, 'General', 1, 1, 'general', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(18, 7, 'General', 1, 1, 'general', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(19, 8, 'General', 1, 1, 'general', NULL);
INSERT INTO `#__eav_attribute_group` VALUES(20, 4, 'Gift Options', 61, 0, 'gift-options', NULL);

DROP TABLE IF EXISTS `#__eav_attribute_label`;
CREATE TABLE `#__eav_attribute_label` (
  `attribute_label_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Attribute Label Id',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Id',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store Id',
  `value` varchar(255) DEFAULT NULL COMMENT 'Value',
  PRIMARY KEY (`attribute_label_id`),
  KEY `EAV_ATTRIBUTE_LABEL_STORE_ID` (`store_id`),
  KEY `EAV_ATTRIBUTE_LABEL_ATTRIBUTE_ID_STORE_ID` (`attribute_id`,`store_id`),
  CONSTRAINT `EAV_ATTRIBUTE_LABEL_ATTRIBUTE_ID_EAV_ATTRIBUTE_ATTRIBUTE_ID` FOREIGN KEY (`attribute_id`) REFERENCES `#__eav_attribute` (`attribute_id`) ON DELETE CASCADE,
  CONSTRAINT `EAV_ATTRIBUTE_LABEL_STORE_ID_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `#__store` (`store_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Eav Attribute Label';

DROP TABLE IF EXISTS `#__eav_attribute_option`;
CREATE TABLE `#__eav_attribute_option` (
  `option_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Option Id',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Id',
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Sort Order',
  PRIMARY KEY (`option_id`),
  KEY `EAV_ATTRIBUTE_OPTION_ATTRIBUTE_ID` (`attribute_id`),
  CONSTRAINT `EAV_ATTRIBUTE_OPTION_ATTRIBUTE_ID_EAV_ATTRIBUTE_ATTRIBUTE_ID` FOREIGN KEY (`attribute_id`) REFERENCES `#__eav_attribute` (`attribute_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Eav Attribute Option';

INSERT INTO `#__eav_attribute_option` VALUES ('1', '20', '0');
INSERT INTO `#__eav_attribute_option` VALUES ('2', '20', '1');
INSERT INTO `#__eav_attribute_option` VALUES ('3', '20', '3');

DROP TABLE IF EXISTS `#__eav_attribute_option_value`;
CREATE TABLE `#__eav_attribute_option_value` (
  `value_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Value Id',
  `option_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Option Id',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store Id',
  `value` varchar(255) DEFAULT NULL COMMENT 'Value',
  PRIMARY KEY (`value_id`),
  KEY `EAV_ATTRIBUTE_OPTION_VALUE_OPTION_ID` (`option_id`),
  KEY `EAV_ATTRIBUTE_OPTION_VALUE_STORE_ID` (`store_id`),
  CONSTRAINT `EAV_ATTRIBUTE_OPTION_VALUE_STORE_ID_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `#__store` (`store_id`) ON DELETE CASCADE,
  CONSTRAINT `EAV_ATTR_OPT_VAL_OPT_ID_EAV_ATTR_OPT_OPT_ID` FOREIGN KEY (`option_id`) REFERENCES `#__eav_attribute_option` (`option_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Eav Attribute Option Value';

-- ----------------------------
-- Records of eav_attribute_option_value
-- ----------------------------
INSERT INTO `#__eav_attribute_option_value` VALUES ('1', '1', '0', 'Male');
INSERT INTO `#__eav_attribute_option_value` VALUES ('2', '2', '0', 'Female');
INSERT INTO `#__eav_attribute_option_value` VALUES ('3', '3', '0', 'Not Specified');

DROP TABLE IF EXISTS `#__eav_attribute_set`;
CREATE TABLE `#__eav_attribute_set` (
  `attribute_set_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Attribute Set Id',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type Id',
  `attribute_set_name` varchar(255) DEFAULT NULL COMMENT 'Attribute Set Name',
  `sort_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Sort Order',
  PRIMARY KEY (`attribute_set_id`),
  UNIQUE KEY `EAV_ATTRIBUTE_SET_ENTITY_TYPE_ID_ATTRIBUTE_SET_NAME` (`entity_type_id`,`attribute_set_name`),
  KEY `EAV_ATTRIBUTE_SET_ENTITY_TYPE_ID_SORT_ORDER` (`entity_type_id`,`sort_order`),
  CONSTRAINT `EAV_ATTRIBUTE_SET_ENTITY_TYPE_ID_EAV_ENTITY_TYPE_ENTITY_TYPE_ID` FOREIGN KEY (`entity_type_id`) REFERENCES `#__eav_entity_type` (`entity_type_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Eav Attribute Set';

INSERT INTO #__eav_attribute_set VALUES ('1', '1', 'Default', '2');
INSERT INTO #__eav_attribute_set VALUES ('2', '2', 'Default', '2');
INSERT INTO #__eav_attribute_set VALUES ('3', '3', 'Default', '1');
INSERT INTO #__eav_attribute_set VALUES ('4', '4', 'Default', '1');
INSERT INTO #__eav_attribute_set VALUES ('5', '5', 'Default', '1');
INSERT INTO #__eav_attribute_set VALUES ('6', '6', 'Default', '1');
INSERT INTO #__eav_attribute_set VALUES ('7', '7', 'Default', '1');
INSERT INTO #__eav_attribute_set VALUES ('8', '8', 'Default', '1');

DROP TABLE IF EXISTS `#__eav_entity`;
CREATE TABLE `#__eav_entity` (
  `entity_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Entity Id',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type Id',
  `attribute_set_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Set Id',
  `increment_id` varchar(50) DEFAULT NULL COMMENT 'Increment Id',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Parent Id',
  `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store Id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At',
  `is_active` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'Defines Is Entity Active',
  PRIMARY KEY (`entity_id`),
  KEY `EAV_ENTITY_ENTITY_TYPE_ID` (`entity_type_id`),
  KEY `EAV_ENTITY_STORE_ID` (`store_id`),
  CONSTRAINT `EAV_ENTITY_ENTITY_TYPE_ID_EAV_ENTITY_TYPE_ENTITY_TYPE_ID` FOREIGN KEY (`entity_type_id`) REFERENCES `#__eav_entity_type` (`entity_type_id`) ON DELETE CASCADE,
  CONSTRAINT `EAV_ENTITY_STORE_ID_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES `#__store` (`store_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Eav Entity';

DROP TABLE IF EXISTS `#__eav_entity_attribute`;
CREATE TABLE `#__eav_entity_attribute` (
  `entity_attribute_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Entity Attribute Id',
  `entity_type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type Id',
  `attribute_set_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Set Id',
  `attribute_group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Group Id',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Id',
  `sort_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Sort Order',
  PRIMARY KEY (`entity_attribute_id`),
  UNIQUE KEY `EAV_ENTITY_ATTRIBUTE_ATTRIBUTE_SET_ID_ATTRIBUTE_ID` (`attribute_set_id`,`attribute_id`),
  UNIQUE KEY `EAV_ENTITY_ATTRIBUTE_ATTRIBUTE_GROUP_ID_ATTRIBUTE_ID` (`attribute_group_id`,`attribute_id`),
  KEY `EAV_ENTITY_ATTRIBUTE_ATTRIBUTE_SET_ID_SORT_ORDER` (`attribute_set_id`,`sort_order`),
  KEY `EAV_ENTITY_ATTRIBUTE_ATTRIBUTE_ID` (`attribute_id`),
  CONSTRAINT `EAV_ENTITY_ATTRIBUTE_ATTRIBUTE_ID_EAV_ATTRIBUTE_ATTRIBUTE_ID` FOREIGN KEY (`attribute_id`) REFERENCES `#__eav_attribute` (`attribute_id`) ON DELETE CASCADE,
  CONSTRAINT `EAV_ENTT_ATTR_ATTR_GROUP_ID_EAV_ATTR_GROUP_ATTR_GROUP_ID` FOREIGN KEY (`attribute_group_id`) REFERENCES `#__eav_attribute_group` (`attribute_group_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8 COMMENT='Eav Entity Attributes';

INSERT INTO `#__eav_entity_attribute` VALUES(1, 1, 1, 1, 1, 10);
INSERT INTO `#__eav_entity_attribute` VALUES(2, 1, 1, 1, 2, 20);
INSERT INTO `#__eav_entity_attribute` VALUES(3, 1, 1, 1, 3, 20);
INSERT INTO `#__eav_entity_attribute` VALUES(4, 1, 1, 1, 4, 30);
INSERT INTO `#__eav_entity_attribute` VALUES(5, 1, 1, 1, 5, 40);
INSERT INTO `#__eav_entity_attribute` VALUES(6, 1, 1, 1, 6, 50);
INSERT INTO `#__eav_entity_attribute` VALUES(7, 1, 1, 1, 7, 60);
INSERT INTO `#__eav_entity_attribute` VALUES(8, 1, 1, 1, 8, 70);
INSERT INTO `#__eav_entity_attribute` VALUES(9, 1, 1, 1, 9, 80);
INSERT INTO `#__eav_entity_attribute` VALUES(10, 1, 1, 1, 10, 25);
INSERT INTO `#__eav_entity_attribute` VALUES(11, 1, 1, 1, 11, 90);
INSERT INTO `#__eav_entity_attribute` VALUES(12, 1, 1, 1, 12, 81);
INSERT INTO `#__eav_entity_attribute` VALUES(13, 1, 1, 1, 13, 115);
INSERT INTO `#__eav_entity_attribute` VALUES(14, 1, 1, 1, 14, 120);
INSERT INTO `#__eav_entity_attribute` VALUES(15, 1, 1, 1, 15, 82);
INSERT INTO `#__eav_entity_attribute` VALUES(16, 1, 1, 1, 16, 83);
INSERT INTO `#__eav_entity_attribute` VALUES(17, 1, 1, 1, 17, 100);
INSERT INTO `#__eav_entity_attribute` VALUES(18, 1, 1, 1, 18, 85);
INSERT INTO `#__eav_entity_attribute` VALUES(19, 1, 1, 1, 19, 86);
INSERT INTO `#__eav_entity_attribute` VALUES(20, 1, 1, 1, 20, 110);
INSERT INTO `#__eav_entity_attribute` VALUES(21, 1, 1, 1, 21, 121);
INSERT INTO `#__eav_entity_attribute` VALUES(22, 2, 2, 2, 22, 10);
INSERT INTO `#__eav_entity_attribute` VALUES(23, 2, 2, 2, 23, 20);
INSERT INTO `#__eav_entity_attribute` VALUES(24, 2, 2, 2, 24, 30);
INSERT INTO `#__eav_entity_attribute` VALUES(25, 2, 2, 2, 25, 40);
INSERT INTO `#__eav_entity_attribute` VALUES(26, 2, 2, 2, 26, 50);
INSERT INTO `#__eav_entity_attribute` VALUES(27, 2, 2, 2, 27, 60);
INSERT INTO `#__eav_entity_attribute` VALUES(28, 2, 2, 2, 28, 70);
INSERT INTO `#__eav_entity_attribute` VALUES(29, 2, 2, 2, 29, 80);
INSERT INTO `#__eav_entity_attribute` VALUES(30, 2, 2, 2, 30, 90);
INSERT INTO `#__eav_entity_attribute` VALUES(31, 2, 2, 2, 31, 100);
INSERT INTO `#__eav_entity_attribute` VALUES(32, 2, 2, 2, 32, 100);
INSERT INTO `#__eav_entity_attribute` VALUES(33, 2, 2, 2, 33, 110);
INSERT INTO `#__eav_entity_attribute` VALUES(34, 2, 2, 2, 34, 120);
INSERT INTO `#__eav_entity_attribute` VALUES(35, 2, 2, 2, 35, 130);
INSERT INTO `#__eav_entity_attribute` VALUES(36, 2, 2, 2, 36, 131);
INSERT INTO `#__eav_entity_attribute` VALUES(37, 2, 2, 2, 37, 132);
INSERT INTO `#__eav_entity_attribute` VALUES(38, 2, 2, 2, 38, 133);
INSERT INTO `#__eav_entity_attribute` VALUES(39, 2, 2, 2, 39, 134);
INSERT INTO `#__eav_entity_attribute` VALUES(40, 2, 2, 2, 40, 135);
INSERT INTO `#__eav_entity_attribute` VALUES(41, 1, 1, 1, 41, 87);
INSERT INTO `#__eav_entity_attribute` VALUES(42, 1, 1, 1, 42, 100);
INSERT INTO `#__eav_entity_attribute` VALUES(43, 1, 1, 1, 43, 110);
INSERT INTO `#__eav_entity_attribute` VALUES(44, 1, 1, 1, 44, 120);
INSERT INTO `#__eav_entity_attribute` VALUES(45, 3, 3, 4, 45, 1);
INSERT INTO `#__eav_entity_attribute` VALUES(46, 3, 3, 4, 46, 2);
INSERT INTO `#__eav_entity_attribute` VALUES(47, 3, 3, 4, 47, 4);
INSERT INTO `#__eav_entity_attribute` VALUES(48, 3, 3, 4, 48, 5);
INSERT INTO `#__eav_entity_attribute` VALUES(49, 3, 3, 4, 49, 6);
INSERT INTO `#__eav_entity_attribute` VALUES(50, 3, 3, 4, 50, 7);
INSERT INTO `#__eav_entity_attribute` VALUES(51, 3, 3, 4, 51, 8);
INSERT INTO `#__eav_entity_attribute` VALUES(52, 3, 3, 5, 52, 10);
INSERT INTO `#__eav_entity_attribute` VALUES(53, 3, 3, 5, 53, 20);
INSERT INTO `#__eav_entity_attribute` VALUES(54, 3, 3, 5, 54, 30);
INSERT INTO `#__eav_entity_attribute` VALUES(55, 3, 3, 4, 55, 12);
INSERT INTO `#__eav_entity_attribute` VALUES(56, 3, 3, 4, 56, 13);
INSERT INTO `#__eav_entity_attribute` VALUES(57, 3, 3, 4, 57, 14);
INSERT INTO `#__eav_entity_attribute` VALUES(58, 3, 3, 4, 58, 15);
INSERT INTO `#__eav_entity_attribute` VALUES(59, 3, 3, 4, 59, 16);
INSERT INTO `#__eav_entity_attribute` VALUES(60, 3, 3, 6, 60, 10);
INSERT INTO `#__eav_entity_attribute` VALUES(61, 3, 3, 6, 61, 30);
INSERT INTO `#__eav_entity_attribute` VALUES(62, 3, 3, 6, 62, 40);
INSERT INTO `#__eav_entity_attribute` VALUES(63, 3, 3, 6, 63, 50);
INSERT INTO `#__eav_entity_attribute` VALUES(64, 3, 3, 6, 64, 60);
INSERT INTO `#__eav_entity_attribute` VALUES(65, 3, 3, 4, 65, 24);
INSERT INTO `#__eav_entity_attribute` VALUES(66, 3, 3, 4, 66, 25);
INSERT INTO `#__eav_entity_attribute` VALUES(67, 3, 3, 5, 67, 40);
INSERT INTO `#__eav_entity_attribute` VALUES(68, 3, 3, 5, 68, 50);
INSERT INTO `#__eav_entity_attribute` VALUES(69, 3, 3, 4, 69, 10);
INSERT INTO `#__eav_entity_attribute` VALUES(70, 3, 3, 6, 70, 5);
INSERT INTO `#__eav_entity_attribute` VALUES(71, 3, 3, 6, 71, 6);
INSERT INTO `#__eav_entity_attribute` VALUES(72, 3, 3, 5, 72, 51);
INSERT INTO `#__eav_entity_attribute` VALUES(73, 4, 4, 7, 73, 10);
INSERT INTO `#__eav_entity_attribute` VALUES(74, 4, 4, 7, 74, 20);
INSERT INTO `#__eav_entity_attribute` VALUES(75, 4, 4, 13, 75, 90);
INSERT INTO `#__eav_entity_attribute` VALUES(76, 4, 4, 13, 76, 100);
INSERT INTO `#__eav_entity_attribute` VALUES(77, 4, 4, 7, 77, 30);
INSERT INTO `#__eav_entity_attribute` VALUES(78, 4, 4, 8, 78, 3);
INSERT INTO `#__eav_entity_attribute` VALUES(79, 4, 4, 8, 79, 4);
INSERT INTO `#__eav_entity_attribute` VALUES(80, 4, 4, 8, 80, 5);
INSERT INTO `#__eav_entity_attribute` VALUES(81, 4, 4, 8, 81, 6);
INSERT INTO `#__eav_entity_attribute` VALUES(82, 4, 4, 7, 82, 70);
INSERT INTO `#__eav_entity_attribute` VALUES(83, 4, 4, 9, 84, 20);
INSERT INTO `#__eav_entity_attribute` VALUES(84, 4, 4, 9, 85, 30);
INSERT INTO `#__eav_entity_attribute` VALUES(85, 4, 4, 9, 86, 40);
INSERT INTO `#__eav_entity_attribute` VALUES(86, 4, 4, 10, 87, 1);
INSERT INTO `#__eav_entity_attribute` VALUES(87, 4, 4, 10, 88, 2);
INSERT INTO `#__eav_entity_attribute` VALUES(88, 4, 4, 10, 89, 3);
INSERT INTO `#__eav_entity_attribute` VALUES(89, 4, 4, 10, 90, 4);
INSERT INTO `#__eav_entity_attribute` VALUES(90, 4, 4, 7, 91, 6);
INSERT INTO `#__eav_entity_attribute` VALUES(91, 4, 4, 8, 92, 7);
INSERT INTO `#__eav_entity_attribute` VALUES(92, 4, 4, 7, 94, 90);
INSERT INTO `#__eav_entity_attribute` VALUES(93, 4, 4, 7, 95, 100);
INSERT INTO `#__eav_entity_attribute` VALUES(94, 4, 4, 10, 96, 5);
INSERT INTO `#__eav_entity_attribute` VALUES(95, 4, 4, 7, 97, 5);
INSERT INTO `#__eav_entity_attribute` VALUES(96, 4, 4, 8, 98, 8);
INSERT INTO `#__eav_entity_attribute` VALUES(97, 4, 4, 7, 99, 80);
INSERT INTO `#__eav_entity_attribute` VALUES(98, 4, 4, 14, 100, 40);
INSERT INTO `#__eav_entity_attribute` VALUES(99, 4, 4, 14, 101, 20);
INSERT INTO `#__eav_entity_attribute` VALUES(100, 4, 4, 14, 102, 30);
INSERT INTO `#__eav_entity_attribute` VALUES(101, 4, 4, 11, 103, 10);
INSERT INTO `#__eav_entity_attribute` VALUES(102, 4, 4, 11, 104, 5);
INSERT INTO `#__eav_entity_attribute` VALUES(103, 4, 4, 7, 105, 80);
INSERT INTO `#__eav_entity_attribute` VALUES(104, 4, 4, 11, 106, 6);
INSERT INTO `#__eav_entity_attribute` VALUES(105, 4, 4, 7, 107, 14);
INSERT INTO `#__eav_entity_attribute` VALUES(106, 4, 4, 7, 108, 15);
INSERT INTO `#__eav_entity_attribute` VALUES(107, 4, 4, 7, 109, 16);
INSERT INTO `#__eav_entity_attribute` VALUES(108, 4, 4, 7, 110, 17);
INSERT INTO `#__eav_entity_attribute` VALUES(109, 4, 4, 7, 111, 18);
INSERT INTO `#__eav_entity_attribute` VALUES(110, 4, 4, 7, 112, 19);
INSERT INTO `#__eav_entity_attribute` VALUES(111, 4, 4, 7, 113, 20);
INSERT INTO `#__eav_entity_attribute` VALUES(112, 4, 4, 7, 114, 110);
INSERT INTO `#__eav_entity_attribute` VALUES(113, 4, 4, 7, 115, 60);
INSERT INTO `#__eav_entity_attribute` VALUES(114, 4, 4, 14, 116, 50);
INSERT INTO `#__eav_entity_attribute` VALUES(115, 3, 3, 4, 117, 3);
INSERT INTO `#__eav_entity_attribute` VALUES(116, 3, 3, 4, 118, 17);
INSERT INTO `#__eav_entity_attribute` VALUES(117, 4, 4, 9, 119, 10);
INSERT INTO `#__eav_entity_attribute` VALUES(118, 4, 4, 7, 120, 11);
INSERT INTO `#__eav_entity_attribute` VALUES(119, 4, 4, 8, 121, 9);
INSERT INTO `#__eav_entity_attribute` VALUES(120, 4, 4, 8, 122, 10);
INSERT INTO `#__eav_entity_attribute` VALUES(121, 4, 4, 7, 123, 31);
INSERT INTO `#__eav_entity_attribute` VALUES(122, 4, 4, 7, 124, 21);
INSERT INTO `#__eav_entity_attribute` VALUES(123, 4, 4, 7, 125, 71);
INSERT INTO `#__eav_entity_attribute` VALUES(124, 4, 4, 8, 126, 11);
INSERT INTO `#__eav_entity_attribute` VALUES(125, 4, 4, 15, 127, 1);
INSERT INTO `#__eav_entity_attribute` VALUES(126, 4, 4, 7, 128, 111);
INSERT INTO `#__eav_entity_attribute` VALUES(127, 4, 4, 7, 129, 112);
INSERT INTO `#__eav_entity_attribute` VALUES(128, 4, 4, 7, 130, 113);
INSERT INTO `#__eav_entity_attribute` VALUES(129, 4, 4, 7, 131, 114);
INSERT INTO `#__eav_entity_attribute` VALUES(130, 4, 4, 10, 132, 3);
INSERT INTO `#__eav_entity_attribute` VALUES(131, 4, 4, 7, 133, 40);
INSERT INTO `#__eav_entity_attribute` VALUES(132, 4, 4, 20, 134, 10);


DROP TABLE IF EXISTS `#__catalog_eav_attribute`;
CREATE TABLE `#__catalog_eav_attribute` (
  `attribute_id` smallint(5) unsigned NOT NULL COMMENT 'Attribute ID',
  `frontend_input_renderer` varchar(255) DEFAULT NULL COMMENT 'Frontend Input Renderer',
  `is_global` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'Is Global',
  `is_visible` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'Is Visible',
  `is_searchable` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Searchable',
  `is_filterable` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Filterable',
  `is_comparable` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Comparable',
  `is_visible_on_front` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Visible On Front',
  `is_html_allowed_on_front` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is HTML Allowed On Front',
  `is_used_for_price_rules` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used For Price Rules',
  `is_filterable_in_search` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Filterable In Search',
  `used_in_product_listing` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used In Product Listing',
  `used_for_sort_by` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used For Sorting',
  `apply_to` varchar(255) DEFAULT NULL COMMENT 'Apply To',
  `is_visible_in_advanced_search` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Visible In Advanced Search',
  `position` int(11) NOT NULL DEFAULT '0' COMMENT 'Position',
  `is_wysiwyg_enabled` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is WYSIWYG Enabled',
  `is_used_for_promo_rules` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used For Promo Rules',
  `is_required_in_admin_store` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Required In Admin Store',
  `is_used_in_grid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used in Grid',
  `is_visible_in_grid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Visible in Grid',
  `is_filterable_in_grid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Filterable in Grid',
  `search_weight` float NOT NULL DEFAULT '1' COMMENT 'Search Weight',
  `additional_data` text COMMENT 'Additional swatch attributes data',
  PRIMARY KEY (`attribute_id`),
  KEY `CATALOG_EAV_ATTRIBUTE_USED_FOR_SORT_BY` (`used_for_sort_by`),
  KEY `CATALOG_EAV_ATTRIBUTE_USED_IN_PRODUCT_LISTING` (`used_in_product_listing`),
  CONSTRAINT `CATALOG_EAV_ATTRIBUTE_ATTRIBUTE_ID_EAV_ATTRIBUTE_ATTRIBUTE_ID` FOREIGN KEY (`attribute_id`) REFERENCES `#__eav_attribute` (`attribute_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catalog EAV Attribute Table';

INSERT INTO `#__catalog_eav_attribute` VALUES(45, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(46, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(47, NULL, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, NULL, 0, 0, 1, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(48, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(49, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(50, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(51, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(52, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(53, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(54, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(55, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(56, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(57, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(58, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(59, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(60, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(61, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(62, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(63, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(64, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(65, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(66, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(67, 'Magento\\Catalog\\Block\\Adminhtml\\Category\\Helper\\Sortby\\Available', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(68, 'Magento\\Catalog\\Block\\Adminhtml\\Category\\Helper\\Sortby\\DefaultSortby', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(69, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(70, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(71, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(72, 'Magento\\Catalog\\Block\\Adminhtml\\Category\\Helper\\Pricestep', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(73, NULL, 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 5, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(74, NULL, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 6, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(75, NULL, 0, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, NULL, 1, 0, 1, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(76, NULL, 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 0, NULL, 1, 0, 1, 0, 0, 1, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(77, NULL, 2, 1, 1, 1, 0, 0, 0, 0, 0, 1, 1, 'simple,virtual,bundle,downloadable,configurable', 1, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(78, NULL, 2, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'simple,virtual,bundle,downloadable,configurable', 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(79, NULL, 2, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'simple,virtual,bundle,downloadable,configurable', 0, 0, 0, 0, 0, 1, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(80, NULL, 2, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'simple,virtual,bundle,downloadable,configurable', 0, 0, 0, 0, 0, 1, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(81, NULL, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'simple,virtual,downloadable', 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(82, 'Magento\\Catalog\\Block\\Adminhtml\\Product\\Helper\\Form\\Weight', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'simple,virtual,bundle,downloadable,configurable', 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(83, NULL, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 'simple', 1, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(84, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(85, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(86, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(87, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(88, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(89, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(90, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(91, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(92, NULL, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'simple,virtual,bundle,downloadable,configurable', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(93, NULL, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 'simple,virtual,configurable', 1, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(94, NULL, 2, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(95, NULL, 2, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(96, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(97, 'Magento\\Framework\\Data\\Form\\Element\\Hidden', 2, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 1, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(98, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'simple,virtual,bundle,downloadable,configurable', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(99, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 1, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(100, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(101, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(102, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(103, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(104, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(105, 'Magento\\Catalog\\Block\\Adminhtml\\Product\\Helper\\Form\\Category', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(106, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(107, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(108, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(109, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(110, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(111, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(112, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(113, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(114, NULL, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'simple,bundle,grouped,configurable', 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(115, 'Magento\\CatalogInventory\\Block\\Adminhtml\\Form\\Field\\Stock', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(116, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(117, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(118, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(119, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(120, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(121, 'Magento\\Msrp\\Block\\Adminhtml\\Product\\Helper\\Form\\Type', 2, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'simple,virtual,downloadable,bundle,configurable', 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(122, 'Magento\\Msrp\\Block\\Adminhtml\\Product\\Helper\\Form\\Type\\Price', 2, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'simple,virtual,downloadable,bundle,configurable', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(123, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'bundle', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(124, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'bundle', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(125, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'bundle', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(126, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'bundle', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(127, NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'bundle', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(128, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'downloadable', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(129, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'downloadable', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(130, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'downloadable', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(131, NULL, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 'downloadable', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(132, NULL, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(133, NULL, 2, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 'simple,virtual,bundle,downloadable,configurable', 0, 0, 0, 0, 0, 1, 0, 1, 1, NULL);
INSERT INTO `#__catalog_eav_attribute` VALUES(134, 'Magento\\GiftMessage\\Block\\Adminhtml\\Product\\Helper\\Form\\Config', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 1, 0, 0, 1, NULL);

SET FOREIGN_KEY_CHECKS=1;