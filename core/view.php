<?php
class View
{
	function generate($template_view, $authorised=null, $data=null, $image=null)
	{
		include 'pages/'.$template_view;
	}
}