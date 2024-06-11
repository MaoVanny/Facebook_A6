<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VideoWithAttributesValidationRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if the file is a video file
        if (!is_file($value)) {
            return false;
        }

        // Check if the file is a video file
        if (!is_readable($value)) {
            return false;
        }

        // Check if the file is a video file
        if (!is_uploaded_file($value)) {
            return false;
        }

        // Check if the file is a video file
        if (!in_array(mime_content_type($value), ['video/mp4', 'video/avi', 'video/mov', 'video/wmv'])) {
            return false;
        }

        // Check if the file is a video file
        if (filesize($value) > 10000000) {
            return false;
        }

        // Check if the file is a video file

        $allowedFormats = ['mp4', 'avi', 'mov', 'wmv'];
        $extension = pathinfo($value, PATHINFO_EXTENSION);
        return in_array($extension, $allowedFormats);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid video file.';
    }
}
