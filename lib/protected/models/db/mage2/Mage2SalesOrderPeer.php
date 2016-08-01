<?php

/**
 * This is the model class for table "sales_order".
 *
 * The followings are the available columns in table 'sales_order':
 * @property string $entity_id
 * @property string $state
 * @property string $status
 * @property string $coupon_code
 * @property string $protect_code
 * @property string $shipping_description
 * @property integer $is_virtual
 * @property integer $store_id
 * @property string $customer_id
 * @property string $base_discount_amount
 * @property string $base_discount_canceled
 * @property string $base_discount_invoiced
 * @property string $base_discount_refunded
 * @property string $base_grand_total
 * @property string $base_shipping_amount
 * @property string $base_shipping_canceled
 * @property string $base_shipping_invoiced
 * @property string $base_shipping_refunded
 * @property string $base_shipping_tax_amount
 * @property string $base_shipping_tax_refunded
 * @property string $base_subtotal
 * @property string $base_subtotal_canceled
 * @property string $base_subtotal_invoiced
 * @property string $base_subtotal_refunded
 * @property string $base_tax_amount
 * @property string $base_tax_canceled
 * @property string $base_tax_invoiced
 * @property string $base_tax_refunded
 * @property string $base_to_global_rate
 * @property string $base_to_order_rate
 * @property string $base_total_canceled
 * @property string $base_total_invoiced
 * @property string $base_total_invoiced_cost
 * @property string $base_total_offline_refunded
 * @property string $base_total_online_refunded
 * @property string $base_total_paid
 * @property string $base_total_qty_ordered
 * @property string $base_total_refunded
 * @property string $discount_amount
 * @property string $discount_canceled
 * @property string $discount_invoiced
 * @property string $discount_refunded
 * @property string $grand_total
 * @property string $shipping_amount
 * @property string $shipping_canceled
 * @property string $shipping_invoiced
 * @property string $shipping_refunded
 * @property string $shipping_tax_amount
 * @property string $shipping_tax_refunded
 * @property string $store_to_base_rate
 * @property string $store_to_order_rate
 * @property string $subtotal
 * @property string $subtotal_canceled
 * @property string $subtotal_invoiced
 * @property string $subtotal_refunded
 * @property string $tax_amount
 * @property string $tax_canceled
 * @property string $tax_invoiced
 * @property string $tax_refunded
 * @property string $total_canceled
 * @property string $total_invoiced
 * @property string $total_offline_refunded
 * @property string $total_online_refunded
 * @property string $total_paid
 * @property string $total_qty_ordered
 * @property string $total_refunded
 * @property integer $can_ship_partially
 * @property integer $can_ship_partially_item
 * @property integer $customer_is_guest
 * @property integer $customer_note_notify
 * @property integer $billing_address_id
 * @property integer $customer_group_id
 * @property integer $edit_increment
 * @property integer $email_sent
 * @property integer $send_email
 * @property integer $forced_shipment_with_invoice
 * @property integer $payment_auth_expiration
 * @property integer $quote_address_id
 * @property integer $quote_id
 * @property integer $shipping_address_id
 * @property string $adjustment_negative
 * @property string $adjustment_positive
 * @property string $base_adjustment_negative
 * @property string $base_adjustment_positive
 * @property string $base_shipping_discount_amount
 * @property string $base_subtotal_incl_tax
 * @property string $base_total_due
 * @property string $payment_authorization_amount
 * @property string $shipping_discount_amount
 * @property string $subtotal_incl_tax
 * @property string $total_due
 * @property string $weight
 * @property string $customer_dob
 * @property string $increment_id
 * @property string $applied_rule_ids
 * @property string $base_currency_code
 * @property string $customer_email
 * @property string $customer_firstname
 * @property string $customer_lastname
 * @property string $customer_middlename
 * @property string $customer_prefix
 * @property string $customer_suffix
 * @property string $customer_taxvat
 * @property string $discount_description
 * @property string $ext_customer_id
 * @property string $ext_order_id
 * @property string $global_currency_code
 * @property string $hold_before_state
 * @property string $hold_before_status
 * @property string $order_currency_code
 * @property string $original_increment_id
 * @property string $relation_child_id
 * @property string $relation_child_real_id
 * @property string $relation_parent_id
 * @property string $relation_parent_real_id
 * @property string $remote_ip
 * @property string $shipping_method
 * @property string $store_currency_code
 * @property string $store_name
 * @property string $x_forwarded_for
 * @property string $customer_note
 * @property string $created_at
 * @property string $updated_at
 * @property integer $total_item_count
 * @property integer $customer_gender
 * @property string $discount_tax_compensation_amount
 * @property string $base_discount_tax_compensation_amount
 * @property string $shipping_discount_tax_compensation_amount
 * @property string $base_shipping_discount_tax_compensation_amnt
 * @property string $discount_tax_compensation_invoiced
 * @property string $base_discount_tax_compensation_invoiced
 * @property string $discount_tax_compensation_refunded
 * @property string $base_discount_tax_compensation_refunded
 * @property string $shipping_incl_tax
 * @property string $base_shipping_incl_tax
 * @property string $coupon_rule_name
 * @property integer $gift_message_id
 * @property integer $paypal_ipn_customer_notified
 */
class Mage2SalesOrderPeer extends Mage2ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sales_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_at, updated_at', 'required'),
			array('is_virtual, store_id, can_ship_partially, can_ship_partially_item, customer_is_guest, customer_note_notify, billing_address_id, customer_group_id, edit_increment, email_sent, send_email, forced_shipment_with_invoice, payment_auth_expiration, quote_address_id, quote_id, shipping_address_id, total_item_count, customer_gender, gift_message_id, paypal_ipn_customer_notified', 'numerical', 'integerOnly'=>true),
			array('state, status, increment_id, customer_prefix, customer_suffix, customer_taxvat, ext_customer_id, ext_order_id, hold_before_state, hold_before_status, original_increment_id, relation_child_id, relation_child_real_id, relation_parent_id, relation_parent_real_id, remote_ip, shipping_method, store_name, x_forwarded_for', 'length', 'max'=>32),
			array('coupon_code, protect_code, shipping_description, discount_description, coupon_rule_name', 'length', 'max'=>255),
			array('customer_id', 'length', 'max'=>10),
			array('base_discount_amount, base_discount_canceled, base_discount_invoiced, base_discount_refunded, base_grand_total, base_shipping_amount, base_shipping_canceled, base_shipping_invoiced, base_shipping_refunded, base_shipping_tax_amount, base_shipping_tax_refunded, base_subtotal, base_subtotal_canceled, base_subtotal_invoiced, base_subtotal_refunded, base_tax_amount, base_tax_canceled, base_tax_invoiced, base_tax_refunded, base_to_global_rate, base_to_order_rate, base_total_canceled, base_total_invoiced, base_total_invoiced_cost, base_total_offline_refunded, base_total_online_refunded, base_total_paid, base_total_qty_ordered, base_total_refunded, discount_amount, discount_canceled, discount_invoiced, discount_refunded, grand_total, shipping_amount, shipping_canceled, shipping_invoiced, shipping_refunded, shipping_tax_amount, shipping_tax_refunded, store_to_base_rate, store_to_order_rate, subtotal, subtotal_canceled, subtotal_invoiced, subtotal_refunded, tax_amount, tax_canceled, tax_invoiced, tax_refunded, total_canceled, total_invoiced, total_offline_refunded, total_online_refunded, total_paid, total_qty_ordered, total_refunded, adjustment_negative, adjustment_positive, base_adjustment_negative, base_adjustment_positive, base_shipping_discount_amount, base_subtotal_incl_tax, base_total_due, payment_authorization_amount, shipping_discount_amount, subtotal_incl_tax, total_due, weight, discount_tax_compensation_amount, base_discount_tax_compensation_amount, shipping_discount_tax_compensation_amount, base_shipping_discount_tax_compensation_amnt, discount_tax_compensation_invoiced, base_discount_tax_compensation_invoiced, discount_tax_compensation_refunded, base_discount_tax_compensation_refunded, shipping_incl_tax, base_shipping_incl_tax', 'length', 'max'=>12),
			array('applied_rule_ids, customer_email, customer_firstname, customer_lastname, customer_middlename', 'length', 'max'=>128),
			array('base_currency_code, global_currency_code, order_currency_code, store_currency_code', 'length', 'max'=>3),
			array('customer_dob, customer_note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('entity_id, state, status, coupon_code, protect_code, shipping_description, is_virtual, store_id, customer_id, base_discount_amount, base_discount_canceled, base_discount_invoiced, base_discount_refunded, base_grand_total, base_shipping_amount, base_shipping_canceled, base_shipping_invoiced, base_shipping_refunded, base_shipping_tax_amount, base_shipping_tax_refunded, base_subtotal, base_subtotal_canceled, base_subtotal_invoiced, base_subtotal_refunded, base_tax_amount, base_tax_canceled, base_tax_invoiced, base_tax_refunded, base_to_global_rate, base_to_order_rate, base_total_canceled, base_total_invoiced, base_total_invoiced_cost, base_total_offline_refunded, base_total_online_refunded, base_total_paid, base_total_qty_ordered, base_total_refunded, discount_amount, discount_canceled, discount_invoiced, discount_refunded, grand_total, shipping_amount, shipping_canceled, shipping_invoiced, shipping_refunded, shipping_tax_amount, shipping_tax_refunded, store_to_base_rate, store_to_order_rate, subtotal, subtotal_canceled, subtotal_invoiced, subtotal_refunded, tax_amount, tax_canceled, tax_invoiced, tax_refunded, total_canceled, total_invoiced, total_offline_refunded, total_online_refunded, total_paid, total_qty_ordered, total_refunded, can_ship_partially, can_ship_partially_item, customer_is_guest, customer_note_notify, billing_address_id, customer_group_id, edit_increment, email_sent, send_email, forced_shipment_with_invoice, payment_auth_expiration, quote_address_id, quote_id, shipping_address_id, adjustment_negative, adjustment_positive, base_adjustment_negative, base_adjustment_positive, base_shipping_discount_amount, base_subtotal_incl_tax, base_total_due, payment_authorization_amount, shipping_discount_amount, subtotal_incl_tax, total_due, weight, customer_dob, increment_id, applied_rule_ids, base_currency_code, customer_email, customer_firstname, customer_lastname, customer_middlename, customer_prefix, customer_suffix, customer_taxvat, discount_description, ext_customer_id, ext_order_id, global_currency_code, hold_before_state, hold_before_status, order_currency_code, original_increment_id, relation_child_id, relation_child_real_id, relation_parent_id, relation_parent_real_id, remote_ip, shipping_method, store_currency_code, store_name, x_forwarded_for, customer_note, created_at, updated_at, total_item_count, customer_gender, discount_tax_compensation_amount, base_discount_tax_compensation_amount, shipping_discount_tax_compensation_amount, base_shipping_discount_tax_compensation_amnt, discount_tax_compensation_invoiced, base_discount_tax_compensation_invoiced, discount_tax_compensation_refunded, base_discount_tax_compensation_refunded, shipping_incl_tax, base_shipping_incl_tax, coupon_rule_name, gift_message_id, paypal_ipn_customer_notified', 'safe', 'on'=>'search'),
		);
	}

    /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mage2SalesOrderPeer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
