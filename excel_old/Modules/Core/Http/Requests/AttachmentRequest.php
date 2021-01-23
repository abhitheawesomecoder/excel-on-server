<?php

namespace Modules\Core\Http\Requests;

use Modules\Core\Http\Requests\Request;

/**
 *
 * Class AttachmentRequest
 * @author Laravel-BAP <hello@laravel-bap.com>
 * @package Modules\Platform\Core\Http\Requests
 */
class AttachmentRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'entityClass' => 'required',
            'entityId' => 'required',
            'files' => 'mimes:'.config('attachments.file_upload_laravel_validation')
        ];
    }
}
