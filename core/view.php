<?php

class View
{
	function generate($template_view, $content_view, $data = null, $params = null)
	{
		include '../app/Views/'.$template_view;
	}
}
