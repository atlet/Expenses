<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class ExpenseAttachment extends Entity {
    protected array $_accessible = [
        'expense_id' => true,
        'filename' => true,
        'file_path' => true,
        'file_size' => true,
        'mime_type' => true,
        'uploaded_by' => true,
        'created' => true,
        'expense' => true,
        'uploader' => true,
    ];

    /**
     * Get human readable file size
     */
    public function getFormattedSize(): string {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get file icon based on mime type
     */
    public function getIcon(): string {
        $mimeType = $this->mime_type;

        if (str_starts_with($mimeType, 'image/')) {
            return 'fa-file-image';
        } elseif ($mimeType === 'application/pdf') {
            return 'fa-file-pdf';
        } elseif (
            str_starts_with($mimeType, 'application/vnd.ms-excel') ||
            str_starts_with($mimeType, 'application/vnd.openxmlformats-officedocument.spreadsheetml')
        ) {
            return 'fa-file-excel';
        } elseif (
            str_starts_with($mimeType, 'application/msword') ||
            str_starts_with($mimeType, 'application/vnd.openxmlformats-officedocument.wordprocessingml')
        ) {
            return 'fa-file-word';
        } else {
            return 'fa-file';
        }
    }

    /**
     * Get color class based on mime type
     */
    public function getColorClass(): string {
        $mimeType = $this->mime_type;

        if (str_starts_with($mimeType, 'image/')) {
            return 'text-success';
        } elseif ($mimeType === 'application/pdf') {
            return 'text-danger';
        } elseif (
            str_starts_with($mimeType, 'application/vnd.ms-excel') ||
            str_starts_with($mimeType, 'application/vnd.openxmlformats-officedocument.spreadsheetml')
        ) {
            return 'text-success';
        } elseif (
            str_starts_with($mimeType, 'application/msword') ||
            str_starts_with($mimeType, 'application/vnd.openxmlformats-officedocument.wordprocessingml')
        ) {
            return 'text-primary';
        } else {
            return 'text-secondary';
        }
    }
}
