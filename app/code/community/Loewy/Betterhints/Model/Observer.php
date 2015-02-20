<?php

class Loewy_Betterhints_Model_Observer
{
	private $block_counter;

	function __construct()
	{
		$this->block_counter = 0;
	}

	function __destruct()
	{
	}

	public function core_block_abstract_to_html_after($observer)
	{
		$event = $observer->getEvent();
		$block = $event->getBlock();
		$transport = $event->getTransport();

		$html = $transport->getHtml();

		if (!$html)
		{
			return;
		}

		$info = '';;

		$info .= 'Class: ' . get_class($block) . "\n";

		if ($block->getNameInLayout())
		{
			$info .= 'Name: ' . $block->getNameInLayout() . "\n";
		}

		if ($block->getBlockAlias() && $block->getBlockAlias() != $block->getNameInLayout())
		{
			$info .= 'Alias: ' . $block->getBlockAlias() . "\n";
		}

		if ($block->getBlockId())
		{
			$info .= 'ID: ' . $block->getBlockId() . "\n";
		}

		if ($block->getTemplate())
		{
			$info .= 'Template: ' . $block->getTemplateFile() . "\n";
		}
		//$info .= 'Module: ' . $block->getModuleName() . "\n";

		$path = array();

		$backtrace = debug_backtrace();
		$path_length = 0;
		foreach ($backtrace as $frame)
		{
			if (isset($frame['object']) && $frame['object'] instanceof Mage_Core_Block_Abstract)
			{
				if ($path_length > 0 && $path[$path_length - 1]['object'] == $frame['object'])
				{
					array_pop($path);
					$path_length--;
				}
				$path[] = $frame;
				$path_length++;
			}
		}

		$info .= 'toHtml() Path:' . "\n";
		for ($i = 0; $i < $path_length; ++$i)
		{
			// this outputs something like
			//    + A
			//    +--+ B
			//       +-- C
			// etc. etc.
			if ($i > 0)
			{
				$info .= "\n";
			}

			$tree_str = '+--+';
			if ($i == 0)
			{
				$tree_str = '   +';
			}
			else if ($i == $path_length - 1)
			{
				$tree_str = '+---';
			}

			$info .= str_repeat('   ', $i) . $tree_str . ' ';

			// the current path segment
			$path_segment = $path[$path_length - 1 - $i];

			// block in the path
			$path_block = $path_segment['object'];

			$path_func = $path_segment['function'];

			// always display class info
			$class_info = get_class($path_block);

			if ($path_func != 'toHtml')
			{
				$class_info .= '::' . $path_func;
			}

			$extra_info = '';

			// add alias, if available
			if ($path_block->getNameInLayout())
			{
				if ($extra_info)
				{
					$extra_info .= ' ';
				}
				$extra_info .= 'Name: ' . $path_block->getNameInLayout();
			}

			// add alias, if available
			if ($path_block->getBlockAlias() && $path_block->getBlockAlias() != $path_block->getNameInLayout())
			{
				if ($extra_info)
				{
					$extra_info .= ' ';
				}
				$extra_info .= 'Alias: ' . $path_block->getBlockAlias();
			}

			// add ID, if available
			if ($path_block->getBlockId())
			{
				if ($extra_info)
				{
					$extra_info .= ' ';
				}
				$extra_info .= 'ID: ' . $path_block->getBlockId();
			}

			// add template, if available
			if ($path_block->getTemplate())
			{
				if ($extra_info)
				{
					$extra_info .= ' ';
				}
				$extra_info .= 'Template: ' . $path_block->getTemplateFile();
			}

			$info .= $class_info;
			if ($extra_info)
			{
				$info .= ' (' . $extra_info . ')';
			}
		}

		$html = '<!-- START BLOCK ' . $this->block_counter . "\n" . $info . ' -->' . $html . '<!-- END BLOCK ' . $this->block_counter . ' -->';

		$this->block_counter++;

		$transport->setHtml($html);
	}
}

?>