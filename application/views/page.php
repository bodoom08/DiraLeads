<?php defined('BASEPATH') or exit('No direct script access allowed');

class Page extends MOBO_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->slug = $this->router->fetch_class();
		$this->slug = $this->slug == 'page' ? 'home' : $this->slug;
		$this->load->model('M_page');
	}

	public function index()
	{
		$data = $this->M_page->getPageData($this->slug);

		if (is_null($data)) {
			// show_404();			
			redirect('notfound','refresh');
			exit;
		}
		
		if($this->slug == 'home') {
			$data['livedata'] = $this->M_page->home_page_livedata();
			$data['areas'] = $this->M_page->get_areas();
			$data['propertiea_counts'] = array_count_values($this->M_page->propertiesCount());
		}
		
		if($this->slug == 'home') {
			$this->load->view('home_new', $data);
		}else{
			$this->load->view('page', $data);
		}
	}

	function appendHTML(DOMNode &$parent, $source) {
		$tmpDoc = new DOMDocument();
		$tmpDoc->loadHTML($source);
		foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
			$node = $parent->ownerDocument->importNode($node, true);
			$parent->appendChild($node);
		}
	}

	public function widgets()
	{
		// $names = json_decode($this->security->xss_clean($this->input->raw_input_stream));
		$names = json_decode($this->security->xss_clean($this->input->post('widgetNames')));
		exit(json_encode($this->M_page->getWidgetData($names)));
	}

	public function contact()
	{
		if($this->input->method() != 'post' || !$this->input->is_ajax_request() ) {
			redirect('/');
		}

		exit(json_encode($this->M_page->contact()));
	}
}
