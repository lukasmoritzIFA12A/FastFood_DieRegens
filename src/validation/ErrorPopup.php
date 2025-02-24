<?php

namespace App\validation;

class ErrorPopup
{
    private string $message;

    public function __construct(string $message = '')
    {
        $this->message = $message;
    }

    public function render(): string
    {
        if (empty($this->message)) {
            return '';
        }

        return <<<HTML
            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalTitle" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="errorModalTitle">Fehler</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {$this->escapeHtml($this->message)}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }

    // Hilfsfunktion zum HTML-Sicher-Machen von Zeichenketten
    private function escapeHtml(string $content): string
    {
        return htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    }
}
