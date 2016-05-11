<?php
class ControllerPaymentAlipayTransfer extends Controller {
	public function index() {
		$this->load->language('payment/alipay_transfer');

		$data['text_instruction'] = $this->language->get('text_instruction');
		$data['text_description'] = $this->language->get('text_description');
		$data['text_payment'] = $this->language->get('text_payment');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['alipay'] = nl2br($this->config->get('alipay_transfer_alipay' . $this->config->get('config_language_id')));

		$data['continue'] = $this->url->link('checkout/success');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . 'payment/alipay_transfer.tpl')) {
			return $this->load->view($this->config->get('config_template') . 'payment/alipay_transfer.tpl', $data);
		} else {
			return $this->load->view('payment/alipay_transfer.tpl', $data);
		}
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'alipay_transfer') {
			$this->load->language('payment/alipay_transfer');

			$this->load->model('checkout/order');

			$comment  = $this->language->get('text_instruction') . "\n\n";
			$comment .= $this->config->get('alipay_transfer_alipay' . $this->config->get('config_language_id')) . "\n\n";
			$comment .= $this->language->get('text_payment');

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('alipay_transfer_order_status_id'), $comment, true);
		}
	}
}