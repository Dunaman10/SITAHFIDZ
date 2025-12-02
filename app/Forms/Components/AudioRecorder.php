<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class AudioRecorder extends Field
{
  protected string $view = 'forms.components.audio-recorder';

  protected string $recordLabel = '🎙 Mulai Rekam';

  public function labelText(string $text): static
  {
    $this->recordLabel = $text;
    return $this;
  }

  protected function setUp(): void
  {
    parent::setUp();

    $this->dehydrated(true);
    $this->statePath('audio');
  }

  public function getLabelText(): string
  {
    return $this->recordLabel;
  }
}
