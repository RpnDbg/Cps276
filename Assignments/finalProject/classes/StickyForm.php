<?php
require_once 'Validation.php';

class StickyForm extends Validation {

    /**
     * Validate form data against a formConfig array.
     * Populates each element’s 'value', 'error', 'checked', 'selected', etc.
     *
     * @param array $data       The $_POST data
     * @param array $formConfig The form configuration array
     * @return array            The updated formConfig with sticky values and errors
     */
    public function validateForm(array $data, array $formConfig): array {
        foreach ($formConfig as $key => &$el) {
            // only process fields that define a type
            if (!isset($el['type'])) {
                continue;
            }

            // make it sticky
            $el['value'] = $data[$key] ?? '';
            $custom      = $el['errorMsg'] ?? null;

            // TEXT & TEXTAREA
            if (in_array($el['type'], ['text','textarea'], true) && isset($el['regex'])) {
                // required?
                if (!empty($el['required']) && $el['value'] === '') {
                    $el['error'] = $custom ?? 'This field is required.';
                    $formConfig['masterStatus']['error'] = true;
                }
                // format?
                elseif ($el['value'] !== '' && !$this->checkFormat($el['value'], $el['regex'], $custom)) {
                    $errs       = $this->getErrors();
                    $el['error'] = $errs[$el['regex']] ?? $custom;
                }
            }

            // SELECT
            elseif ($el['type'] === 'select') {
                $el['selected'] = $data[$key] ?? '';
                if (!empty($el['required']) && in_array($el['selected'], ['', '0'], true)) {
                    $el['error'] = $custom ?? 'This field is required.';
                    $formConfig['masterStatus']['error'] = true;
                }
            }

            // CHECKBOX (single or group)
            elseif ($el['type'] === 'checkbox') {
                if (isset($el['options'])) {
                    $any = false;
                    foreach ($el['options'] as &$opt) {
                        $opt['checked'] = in_array($opt['value'], $data[$key] ?? [], true);
                        $any = $any || $opt['checked'];
                    }
                    if (!empty($el['required']) && !$any) {
                        $el['error'] = $custom ?? 'This field is required.';
                        $formConfig['masterStatus']['error'] = true;
                    }
                } else {
                    $el['checked'] = isset($data[$key]);
                    if (!empty($el['required']) && !$el['checked']) {
                        $el['error'] = $custom ?? 'This field is required.';
                        $formConfig['masterStatus']['error'] = true;
                    }
                }
            }

            // RADIO
            elseif ($el['type'] === 'radio') {
                $checked = false;
                foreach ($el['options'] as &$opt) {
                    $opt['checked'] = ($opt['value'] === ($data[$key] ?? ''));
                    $checked = $checked || $opt['checked'];
                }
                if (!empty($el['required']) && !$checked) {
                    $el['error'] = $custom ?? 'This field is required.';
                    $formConfig['masterStatus']['error'] = true;
                }
            }
        }

        return $formConfig;
    }

    /** Build <option> tags for a select. */
    public function createOptions(array $opts, $selVal): string {
        $html = '';
        foreach ($opts as $v => $l) {
            $s = ($v == $selVal) ? 'selected' : '';
            $html .= "<option value=\"$v\" $s>$l</option>";
        }
        return $html;
    }

    /** Render an error message under a field. */
    private function renderError(array $el): string {
        return !empty($el['error'])
            ? "<span class=\"text-danger\">{$el['error']}</span><br>"
            : '';
    }

    /** Render a text input. */
    public function renderInput(array $el, string $cls=''): string {
        $err = $this->renderError($el);
        return <<<HTML
<div class="$cls">
  <label for="{$el['id']}">{$el['label']}</label>
  <input type="text" class="form-control" id="{$el['id']}" name="{$el['name']}" value="{$el['value']}">
  $err
</div>
HTML;
    }

    /** Render a textarea. */
    public function renderTextarea(array $el, string $cls=''): string {
        $err = $this->renderError($el);
        return <<<HTML
<div class="$cls">
  <label for="{$el['id']}">{$el['label']}</label>
  <textarea class="form-control" id="{$el['id']}" name="{$el['name']}">{$el['value']}</textarea>
  $err
</div>
HTML;
    }

    /** Render a select box. */
    public function renderSelect(array $el, string $cls=''): string {
        $err = $this->renderError($el);
        $opt = $this->createOptions($el['options'], $el['selected']);
        return <<<HTML
<div class="$cls">
  <label for="{$el['id']}">{$el['label']}</label>
  <select class="form-control" id="{$el['id']}" name="{$el['name']}">
    $opt
  </select>
  $err
</div>
HTML;
    }

    /** Render a single checkbox. */
    public function renderCheckbox(array $el, string $cls='', string $layout='vertical'): string {
        $err = $this->renderError($el);
        $inl = $layout==='horizontal' ? 'form-check-inline' : '';
        $chk = !empty($el['checked']) ? 'checked' : '';
        return <<<HTML
<div class="$cls">
  <div class="form-check $inl">
    <input class="form-check-input" type="checkbox" id="{$el['id']}" name="{$el['name']}" $chk>
    <label class="form-check-label" for="{$el['id']}">{$el['label']}</label>
  </div>
  $err
</div>
HTML;
    }

    /** Render a group of checkboxes. */
    public function renderCheckboxGroup(array $el, string $cls='', string $layout='vertical'): string {
        $err = $this->renderError($el);
        $inl = $layout==='horizontal' ? 'form-check-inline' : '';
        $html = '';
        foreach ($el['options'] as $i => $o) {
            $id  = "{$el['id']}_{$i}";
            $chk = !empty($o['checked']) ? 'checked' : '';
            $html .= <<<HTML
<div class="form-check $inl">
  <input class="form-check-input" type="checkbox" id="$id" name="{$el['name']}[]" value="{$o['value']}" $chk>
  <label class="form-check-label" for="$id">{$o['label']}</label>
</div>
HTML;
        }
        return <<<HTML
<div class="$cls">
  <label>{$el['label']}</label><br>
  $html
  $err
</div>
HTML;
    }

    /** Render a set of radio buttons. */
    public function renderRadio(array $el, string $cls='', string $layout='vertical'): string {
        $err = $this->renderError($el);
        $inl = $layout==='horizontal' ? 'form-check-inline' : '';
        $html = '';
        foreach ($el['options'] as $o) {
            $id  = "{$el['id']}_{$o['value']}";
            $chk = !empty($o['checked']) ? 'checked' : '';
            $html .= <<<HTML
<div class="form-check $inl">
  <input class="form-check-input" type="radio" id="$id" name="{$el['name']}" value="{$o['value']}" $chk>
  <label class="form-check-label" for="$id">{$o['label']}</label>
</div>
HTML;
        }
        return <<<HTML
<div class="$cls">
  <label>{$el['label']}</label><br>
  $html
  $err
</div>
HTML;
    }
}
?>
