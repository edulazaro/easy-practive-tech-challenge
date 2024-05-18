<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\StringHelper;

class StringHelperTest extends TestCase
{
    /**
     * The same content should be returned if the string is under 255 characters 
     */
    public function test_returns_full_text_if_under_max_length()
    {
        $text = "Hello buddy!";
        $result = StringHelper::getExcerpt($text);

        $this->assertEquals($text, $result);
    }

    /**
     * The same content should be returned if the text has exactly 255 characters
     */ 
    public function test_returns_full_text_if_exactly_max_length()
    {
        $text = str_repeat("a", 255);
        $result = StringHelper::getExcerpt($text);

        $this->assertEquals($text, $result);
    }

    /**
     * The content should be truncated for string lengths over 255 characters
     */ 
    public function test_text_is_truncated_over_max_length()
    {
        $text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
        $result = StringHelper::getExcerpt($text, 50);
        $expected = "Lorem ipsum dolor sit amet, consectetur...";

        $this->assertEquals($expected, $result);
    }

    /**
     * The text should be truncated at the specified lenght
     */
    public function test_text_trucated_when_providing_length()
    {
        $text = "Quick brown fox jumps over the lazy dog.";

        $result = StringHelper::getExcerpt($text, 10);
        $this->assertEquals("Quick...", $result);

        $result = StringHelper::getExcerpt($text, 20);
        $this->assertEquals("Quick brown fox...", $result);
    }
}