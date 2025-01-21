<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureRequest extends Model
{
    use HasFactory;

    // Constants for database column names
    public const SENDER_ID_ATTRIBUTE = 'sender_id';
    public const RECEIVER_ID_ATTRIBUTE = 'receiver_id';
    public const DOCUMENT_ID_ATTRIBUTE = 'document_id';
    public const STATUS_ATTRIBUTE = 'status';
    public const SIGNED_AT_ATTRIBUTE = 'signed_at';

    // Allowed statuses for signature requests
    public const STATUS_PENDING = 'pending';
    public const STATUS_SIGNED = 'signed';
    public const STATUS_DECLINED = 'declined';

    protected $fillable = [
        self::SENDER_ID_ATTRIBUTE,
        self::RECEIVER_ID_ATTRIBUTE,
        self::DOCUMENT_ID_ATTRIBUTE,
        self::STATUS_ATTRIBUTE,
        self::SIGNED_AT_ATTRIBUTE,
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, self::SENDER_ID_ATTRIBUTE);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, self::RECEIVER_ID_ATTRIBUTE);
    }

    public function document()
    {
        return $this->belongsTo(Document::class, self::DOCUMENT_ID_ATTRIBUTE);
    }
}

