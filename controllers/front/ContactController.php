<?php

namespace Controllers\Front;

use Src\Helpers\Translator;
use Src\Controller;
use Src\Helpers\Mail;
use Src\Helpers\Validate;

class ContactController extends Controller{
    
    // TODO: przerobić na obiekt Form 
    protected $form;

    public function init($param = false)
    {
        $this->form = $this->initForm();
        return parent::init();
    }

    public function setTemplate(): void
    {
        $this->theme->template = 'pages/contact';
    }

    public function getTemplateVarPage(): array
    {
        $vars = parent::getTemplateVarPage();
        $vars['meta_title'] = 'Kontakt';
        $vars['meta_description'] = '';
        $vars['name'] = 'contact';
        return $vars;
    }

    public function initForm()
    {
        return [
            'contact_form' => [
                'title' => Translator::trans('Formularz kontaktowy'),
                'input' => [
                    'name' => [
                        'type' => 'text',
                        'label' => Translator::trans('Imię i Nazwisko'),
                        'validate' => 'isString',
                        'required' => true,
                        'min' => 3
                    ],
                    'email' => [
                        'type' => 'email',
                        'label' => Translator::trans('Adres e-mail'),
                        'validate' => 'isEmail',
                        'required' => true
                    ],
                    'content' => [
                        'type' => 'textarea',
                        'label' => Translator::trans('Wiadomość'),
                        'required' => true,
                        'min' => 3
                    ],
                    'rule' => [
                        'type' => 'checkbox',
                        'required' => true,
                        'label' => Translator::trans('Oświadczam, że zapoznałem się z polityką prywatności oraz w pełni akceptuje zawartej w niej postanowienia'),
                        'validate' => 'isBool'
                    ],
                    'special' => [
                        'type' => 'hidden'
                    ]
                ],
                'submit' => [
                    'name' => 'submitContact',
                    'label' => Translator::trans('Wyślij')
                ]
            ]
        ];
    }

    public function getTemplateVarForm(): array
    {
        return $this->form;
    }

    public function postProcess()
    {
        if($this->request->isSubmit('submitContact') && !empty($this->form)){

            if ($this->session->get('contact_form')) {
                $this->theme->addWarning('contact_form', Translator::trans('Otrzymaliśmy już wiadomość, skontaktujemy się najszybciej jak to możliwe.'));
            } else {

                $this->fillFormWithPost();
                if($this->validateForm() && Mail::send(
                    Translator::trans('Nowa wiadomość ze strony Format Meble'),
                    $this->getFormValue('email'),
                    $this->getEmailHtml($this->getVarsForMessage()),
                    $this->getEmailText($this->getVarsForMessage())
                )){
                    $this->clearForm();
                    $this->theme->addSuccess('contact-form', Translator::trans('Dziękujemy za wysłanie wiadomości, odpowiemy najszybciej jak to możliwe.'));
                    $this->session->set('contact_form', true);
                }
            } 
        }
    }

    public function fillFormWithPost()
    {
        foreach($this->form['contact_form']['input'] as $key => &$input){

            $input['value'] = $this->request->getValue($key);

        }

        unset($input);
    }

    public function validateForm()
    {
        $output = true;
        foreach($this->form['contact_form']['input'] as $key => &$input){
            if($key == 'is_special' && !empty($input['value'])){
                $this->form['contact_form']['errors'][] = Translator::trans('System wykrył działanie robota, prosimy o kontakt telefoniczny lub mailowy.');
                $output = false;
            }
            if(isset($input['required']) && $input['required'] && empty($input['value'])){
                $input['errors'][] = Translator::trans('To pole jest wymagane!');
                $output = false;
            }
            if(isset($input['validate']) && !Validate::{$input['validate']}($input['value'])){
                $input['errors'][] = Translator::trans('Wprowadzono nieprawidłową wartość!');
                $output = false;
            }
            if(isset($input['min']) && strlen($input['value']) < $input['min']){
                $input['errors'][] = Translator::trans('To pole powinno zawierać minimum %s znaków', $input['min']);
                $output = false;
            }
            if(isset($input['max']) && strlen($input['value']) > $input['max']){
                $input['errors'][] = Translator::trans('To pole nie może zawierać więcej niż %s znaków', $input['max']);
                $output = false;
            }
        }
        unset($input);
        return $output;
    }

    public function clearForm()
    {
        foreach($this->form['contact_form']['input'] as &$input){
            $input['value'] = '';
        }
        unset($input);
    }

    public function getFormValue($key)
    {
        foreach($this->form['contact_form']['input'] as $name => $input)
        {
            if($name == $key){
                return $input['value'];
            }
        }

        return false;
    }

    public function getVarsForMessage()
    {
        $vars['email'] = $this->getFormValue('email');
        $vars['name'] = $this->getFormValue('name');
        $vars['content'] = $this->getFormValue('content');
        return $vars;
    }

    public function getEmailHtml($vars)
    {
        ob_start();
        include($this->theme->getDir() . 'mails/contact.html');
        return ob_get_clean();
    }
    public function getEmailText($vars)
    {
        return '
            Nowa wiadomość z formularza kontaktowego '. PHP_EOL .'
            Imię i Nazwisko: '.$vars['name']. PHP_EOL . '
            Email: '.$vars['name']. PHP_EOL . '
            Wiadomość: '. PHP_EOL .'
            '.$vars['name'].'
        ';
    }
}