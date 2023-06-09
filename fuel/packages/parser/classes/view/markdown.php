<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

namespace Parser;

class View_Markdown extends \View
{
	protected static $_parser;

	protected function process_file($file_override = false)
	{
		$file = $file_override ?: $this->file_name;

		$contents = '';

		if (\Config::get('parser.View_Markdown.allow_php', false))
		{
			$contents = static::pre_process($file, 'php', $data = $this->get_data());
			$this->unsanitize($data);
		}
		else
		{
			$contents = file_get_contents($file);
		}

		return static::parser()->transform($contents);
	}

	protected static function pre_process($_view_filename, $_type = 'php', array $_data = array())
	{
		if ($_type == 'php')
		{
			// Import the view variables to local namespace
			$_data AND extract($_data, EXTR_REFS);

			// Capture the view output
			ob_start();

			try
			{
				// Load the view within the current scope
				include $_view_filename;
			}
			catch (\Exception $e)
			{
				// Delete the output buffer
				ob_end_clean();

				// Re-throw the exception
				throw $e;
			}

			// Get the captured output and close the buffer
			return ob_get_clean();
		}
	}

	public $extension = 'md';

	/**
	 * Returns the Parser lib object
	 *
	 * @return  Markdown_Parser
	 */
	public static function parser()
	{
		static $parser = null;
		if (is_null($parser))
		{
			$parser = new \Michelf\MarkdownExtra();
		}

		return $parser;
	}
}
