<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;

class ExpenseAttachmentsController extends AppController {
    public function upload($expenseId = null) {
        $this->request->allowMethod(['post']);

        $expensesTable = $this->fetchTable('Expenses');

        // Preveri ali expense obstaja
        if (!$expensesTable->exists(['id' => $expenseId])) {
            throw new NotFoundException(__('Expense not found'));
        }

        $uploadedFiles = $this->request->getUploadedFiles();

        if (empty($uploadedFiles['files'])) {
            $this->Flash->error(__('No files were uploaded'));
            return $this->redirect(['controller' => 'Expenses', 'action' => 'view', $expenseId]);
        }

        $files = $uploadedFiles['files'];
        if (!is_array($files)) {
            $files = [$files];
        }

        $savedCount = 0;
        $errors = [];

        foreach ($files as $file) {
            if ($file->getError() !== UPLOAD_ERR_OK) {
                $errors[] = $file->getClientFilename() . ': ' . __('Upload error');
                continue;
            }

            // Validation
            $allowedMimeTypes = [
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp',
                'application/pdf',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ];

            $mimeType = $file->getClientMediaType();

            if (!in_array($mimeType, $allowedMimeTypes)) {
                $errors[] = $file->getClientFilename() . ': ' . __('File type not allowed');
                continue;
            }

            // Max file size: 10MB
            if ($file->getSize() > 10 * 1024 * 1024) {
                $errors[] = $file->getClientFilename() . ': ' . __('File too large (max 10MB)');
                continue;
            }

            // Generate unique filename
            $originalName = $file->getClientFilename();
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $uniqueName = uniqid() . '_' . time() . '.' . $extension;

            // Storage path (outside webroot!)
            $storagePath = ROOT . DS . 'storage' . DS . 'expenses' . DS . 'attachments' . DS;

            // Create directory if not exists
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            $fullPath = $storagePath . $uniqueName;

            try {
                // Move uploaded file
                $file->moveTo($fullPath);

                // Save to database
                $attachment = $this->ExpenseAttachments->newEntity([
                    'expense_id' => $expenseId,
                    'filename' => $originalName,
                    'file_path' => $uniqueName,
                    'file_size' => $file->getSize(),
                    'mime_type' => $mimeType,
                    'uploaded_by' => $this->Authentication->getIdentity()->getIdentifier(),
                ]);

                if ($this->ExpenseAttachments->save($attachment)) {
                    $savedCount++;
                } else {
                    $errors[] = $originalName . ': ' . __('Database save failed');
                    @unlink($fullPath);
                }
            } catch (\Exception $e) {
                $errors[] = $originalName . ': ' . $e->getMessage();
            }
        }

        if ($savedCount > 0) {
            $this->Flash->success(__('Successfully uploaded {0} file(s)', $savedCount));
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                $this->Flash->error($error);
            }
        }

        return $this->redirect(['controller' => 'Expenses', 'action' => 'view', $expenseId]);
    }

    public function download($id = null) {
        $attachment = $this->ExpenseAttachments->get($id, contain: ['Expenses']);

        $storagePath = ROOT . DS . 'storage' . DS . 'expenses' . DS . 'attachments' . DS;
        $fullPath = $storagePath . $attachment->file_path;

        if (!file_exists($fullPath)) {
            throw new NotFoundException(__('File not found'));
        }

        // Return file as download
        $response = $this->response->withFile(
            $fullPath,
            ['download' => true, 'name' => $attachment->filename]
        );

        return $response;
    }

    public function view($id = null) {
        $attachment = $this->ExpenseAttachments->get($id, contain: ['Expenses']);

        $storagePath = ROOT . DS . 'storage' . DS . 'expenses' . DS . 'attachments' . DS;
        $fullPath = $storagePath . $attachment->file_path;

        if (!file_exists($fullPath)) {
            throw new NotFoundException(__('File not found'));
        }

        // Return file for inline viewing (PDF, images)
        $response = $this->response->withFile(
            $fullPath,
            ['download' => false]
        );

        return $response;
    }

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);

        $attachment = $this->ExpenseAttachments->get($id);
        $expenseId = $attachment->expense_id;

        // Delete file from disk
        $storagePath = ROOT . DS . 'storage' . DS . 'expenses' . DS . 'attachments' . DS;
        $fullPath = $storagePath . $attachment->file_path;

        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }

        // Delete from database
        if ($this->ExpenseAttachments->delete($attachment)) {
            $this->Flash->success(__('The attachment has been deleted.'));
        } else {
            $this->Flash->error(__('The attachment could not be deleted.'));
        }

        return $this->redirect(['controller' => 'Expenses', 'action' => 'view', $expenseId]);
    }
}
