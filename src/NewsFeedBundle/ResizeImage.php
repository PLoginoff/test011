<?php
/**
 * ResizeImage
 *
 * PHP version 5.6
 *
 * @category Class
 * @package  NewsFeedBundle
 * @author   Pavel Loginov <ploginoff@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.example.com/
 */

namespace NewsFeedBundle;

use Eventviva\ImageResize;

/**
 * ResizeImage
 *
 * @category Class
 * @package  NewsFeedBundle
 * @author   Pavel Loginov <ploginoff@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.example.com/
 */
class ResizeImage
{
    protected $filename;

    /**
     * Construnct
     *
     * @param string $filename File
     *
     * @return null
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Resize
     *
     * @param int $width  Width
     * @param int $height Height
     * 
     * @return boolena
     */
    public function resize($width = 100, $height = 100)
    {
        $image = new ImageResize($this->filename);
        $image->resizeToWidth($width);
        $image->crop($width, $height);
        return $image->save($this->filename);
    }
}