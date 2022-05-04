<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* interlocuteur/interlocuteur/_form.html.twig */
class __TwigTemplate_093d34bb5e021e2929310922007facc5 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "interlocuteur/interlocuteur/_form.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "interlocuteur/interlocuteur/_form.html.twig"));

        // line 1
        echo "<style>
    input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa
    }

    input.invalid {
        background-color: #ffdddd
    }

    .tab {
        display: none
    }

    button {
        background-color: #4CAF50;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Raleway;
        cursor: pointer
    }

    button:hover {
        opacity: 0.8
    }

    #prevBtn {
        background-color: #bbbbbb
    }

    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5
    }

    .step.active {
        opacity: 1
    }

    .step.finish {
        background-color: #4CAF50
    }

    .all-steps {
        text-align: center;
        margin-top: 30px;
        margin-bottom: 30px
    }

    .thanks-message {
        display: none
    }

    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none
    }

    .container input[type=\"radio\"] {
        width: min-content;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%
    }

    .container:hover input ~ .checkmark {
        background-color: #ccc
    }

    .container input:checked ~ .checkmark {
        background-color: #2196F3
    }

    .checkmark:after {
        content: \"\";
        position: absolute;
        display: none
    }

    .container input:checked ~ .checkmark:after {
        display: block
    }

    .container .checkmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white
    }
</style>
<div class=\"container mt-5\">
    <div class=\"row d-flex justify-content-center align-items-center\">
        <div class=\"col-md-6\">
            ";
        // line 122
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 122, $this->source); })()), 'form_start', ["attr" => ["id" => "regForm"]]);
        echo "

            <h1 id=\"register\">Ajouter un Interlocuteur</h1>
            <div class=\"all-steps\" id=\"all-steps\">
                <span class=\"step\"></span>
                <span class=\"step\"></span>
                <span class=\"step\"></span>
            <div class=\"tab\">

                <h3>Type d'interlocuteur:</h3>
                ";
        // line 132
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 132, $this->source); })()), "type", [], "any", false, false, false, 132), 'widget');
        echo "
            </div>
            <div class=\"tab\">

                <div class=\"societe\">
                    <p>";
        // line 137
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 137, $this->source); })()), "societe", [], "any", false, false, false, 137), "raisonSociale", [], "any", false, false, false, 137), 'widget');
        echo " </p>
                    <p>";
        // line 138
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 138, $this->source); })()), "societe", [], "any", false, false, false, 138), "nom", [], "any", false, false, false, 138), 'widget');
        echo " </p>
                    <p>";
        // line 139
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 139, $this->source); })()), "societe", [], "any", false, false, false, 139), "siret", [], "any", false, false, false, 139), 'widget');
        echo " </p>
                    <p>";
        // line 140
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 140, $this->source); })()), "societe", [], "any", false, false, false, 140), "formeJuridique", [], "any", false, false, false, 140), 'widget');
        echo " </p>
                    <p>";
        // line 141
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 141, $this->source); })()), "societe", [], "any", false, false, false, 141), "activitePrincipale", [], "any", false, false, false, 141), 'widget');
        echo " </p>
                    <p>";
        // line 142
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 142, $this->source); })()), "societe", [], "any", false, false, false, 142), "dirigeant", [], "any", false, false, false, 142), 'widget');
        echo " </p>
                    <p>";
        // line 143
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 143, $this->source); })()), "societe", [], "any", false, false, false, 143), "dateDeCreation", [], "any", false, false, false, 143), 'widget');
        echo " </p>
                    <p>";
        // line 144
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 144, $this->source); })()), "societe", [], "any", false, false, false, 144), "email", [], "any", false, false, false, 144), 'widget');
        echo " </p>
                    <p>";
        // line 145
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 145, $this->source); })()), "societe", [], "any", false, false, false, 145), "adresse1", [], "any", false, false, false, 145), 'widget');
        echo " </p>
                    <p>";
        // line 146
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 146, $this->source); })()), "societe", [], "any", false, false, false, 146), "adresse2", [], "any", false, false, false, 146), 'widget');
        echo " </p>
                    <p>";
        // line 147
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 147, $this->source); })()), "societe", [], "any", false, false, false, 147), "ville", [], "any", false, false, false, 147), 'widget');
        echo " </p>
                    <p>";
        // line 148
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 148, $this->source); })()), "societe", [], "any", false, false, false, 148), "codePostal", [], "any", false, false, false, 148), 'widget');
        echo " </p>
                    <p>";
        // line 149
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 149, $this->source); })()), "societe", [], "any", false, false, false, 149), "pays", [], "any", false, false, false, 149), 'widget');
        echo " </p>

                </div>
                <div class=\"personne\">
                    <p>";
        // line 153
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 153, $this->source); })()), "personne", [], "any", false, false, false, 153), "nom", [], "any", false, false, false, 153), 'widget');
        echo " </p>
                    <p>";
        // line 154
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 154, $this->source); })()), "personne", [], "any", false, false, false, 154), "prenom", [], "any", false, false, false, 154), 'widget');
        echo " </p>
                    <p>";
        // line 155
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 155, $this->source); })()), "personne", [], "any", false, false, false, 155), "email", [], "any", false, false, false, 155), 'widget');
        echo " </p>
                    <p>";
        // line 156
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 156, $this->source); })()), "personne", [], "any", false, false, false, 156), "adresse1", [], "any", false, false, false, 156), 'widget');
        echo " </p>
                    <p>";
        // line 157
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 157, $this->source); })()), "personne", [], "any", false, false, false, 157), "adresse2", [], "any", false, false, false, 157), 'widget');
        echo " </p>
                    <p>";
        // line 158
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 158, $this->source); })()), "personne", [], "any", false, false, false, 158), "ville", [], "any", false, false, false, 158), 'widget');
        echo " </p>
                    <p>";
        // line 159
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 159, $this->source); })()), "personne", [], "any", false, false, false, 159), "codePostal", [], "any", false, false, false, 159), 'widget');
        echo " </p>
                    <p>";
        // line 160
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 160, $this->source); })()), "personne", [], "any", false, false, false, 160), "pays", [], "any", false, false, false, 160), 'widget');
        echo " </p>
                </div>
            </div>
            <div class=\"tab\">
                <p>";
        // line 164
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 164, $this->source); })()), "commentaire", [], "any", false, false, false, 164), 'widget');
        echo " </p>
            </div>
            <div style=\"overflow:auto;\" id=\"nextprevious\">
                <div style=\"float:right;\">
                    <button type=\"button\" id=\"prevBtn\" onclick=\"nextPrev(-1)\">Précédent</button>
                    <button type=\"button\" id=\"nextBtn\" onclick=\"nextPrev(1)\">Suivant</button>
                </div>
            </div>
            ";
        // line 172
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 172, $this->source); })()), 'form_end');
        echo "
        </div>
    </div>
</div>



<script>



    \$(\"input:radio[name='interlocuteur[type]']\").val() === \"personne\" ? \$('.personne').show() && \$('.societe').hide() && disableRequired(\"personne-form\",\"societe-form\") : \$('.personne').hide() && \$('.societe').show() && disableRequired(\"societe-form\",\"personne-form\")

    function disableRequired(actif,inactif){
       \$('.'+inactif).each(function () {
           \$(this).attr('required',false)
           console.log(\$(this).attr('class'))
       })

       \$('.'+actif).each(function () {
           if(\$(this).hasClass('required')) {
               \$(this).attr('required',true)
           }
       })
       
   }

    \$(\"input:radio[name='interlocuteur[type]']\").on(\"change\", function() {
        \$(this).val() === \"personne\" ? \$('.personne').show() && \$('.societe').hide() && disableRequired(\"personne-form\",\"societe-form\") : \$('.personne').hide() && \$('.societe').show() && disableRequired(\"societe-form\",\"personne-form\")

    })


    //your javascript goes here
    var currentTab = 0;
    document.addEventListener(\"DOMContentLoaded\", function (event) {


        showTab(currentTab);

    });

    \$('.submit').click(function (){
        \$('form').submit();
    })

    function showTab(n) {
        var x = document.getElementsByClassName(\"tab\");
        x[n].style.display = \"block\";
        if (n == 0) {
            document.getElementById(\"prevBtn\").style.display = \"none\";
        } else {
            document.getElementById(\"prevBtn\").style.display = \"inline\";
        }

        if (n == (x.length - 1)) {

            const submit =     '<button class=\"nextBtn\">";
        // line 229
        echo twig_escape_filter($this->env, ((array_key_exists("button_label", $context)) ? (_twig_default_filter((isset($context["button_label"]) || array_key_exists("button_label", $context) ? $context["button_label"] : (function () { throw new RuntimeError('Variable "button_label" does not exist.', 229, $this->source); })()), "Save")) : ("Save")), "html", null, true);
        echo "</button>';
            \$('#nextBtn').replaceWith(submit)
        } else {
            document.getElementById(\"nextBtn\").innerHTML = \"Next\";
        }
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        var x = document.getElementsByClassName(\"tab\");
        if (n == 1 && !validateForm()) return false;
        x[currentTab].style.display = \"none\";
        currentTab = currentTab + n;
        if (currentTab >= x.length) {

            document.getElementById(\"nextprevious\").style.display = \"none\";
            document.getElementById(\"all-steps\").style.display = \"none\";
            document.getElementById(\"register\").style.display = \"none\";
            document.getElementById(\"text-message\").style.display = \"block\";


        }
        showTab(currentTab);
    }

    function validateForm() {
        var x, y, i, valid = true;
        x = document.getElementsByClassName(\"tab\");
        y = x[currentTab].getElementsByTagName(\"input\");
        for (i = 0; i < y.length; i++) {
            if (y[i].value == \"\" && y[i].required) {
                y[i].className += \" invalid\";
                valid = false;
            }
        }
        if (valid) {
            document.getElementsByClassName(\"step\")[currentTab].className += \" finish\";
        }
        return valid;
    }

    function fixStepIndicator(n) {
        var i, x = document.getElementsByClassName(\"step\");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(\" active\", \"\");
        }
        x[n].className += \" active\";
    }
</script>";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    public function getTemplateName()
    {
        return "interlocuteur/interlocuteur/_form.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  348 => 229,  288 => 172,  277 => 164,  270 => 160,  266 => 159,  262 => 158,  258 => 157,  254 => 156,  250 => 155,  246 => 154,  242 => 153,  235 => 149,  231 => 148,  227 => 147,  223 => 146,  219 => 145,  215 => 144,  211 => 143,  207 => 142,  203 => 141,  199 => 140,  195 => 139,  191 => 138,  187 => 137,  179 => 132,  166 => 122,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<style>
    input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa
    }

    input.invalid {
        background-color: #ffdddd
    }

    .tab {
        display: none
    }

    button {
        background-color: #4CAF50;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Raleway;
        cursor: pointer
    }

    button:hover {
        opacity: 0.8
    }

    #prevBtn {
        background-color: #bbbbbb
    }

    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5
    }

    .step.active {
        opacity: 1
    }

    .step.finish {
        background-color: #4CAF50
    }

    .all-steps {
        text-align: center;
        margin-top: 30px;
        margin-bottom: 30px
    }

    .thanks-message {
        display: none
    }

    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none
    }

    .container input[type=\"radio\"] {
        width: min-content;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%
    }

    .container:hover input ~ .checkmark {
        background-color: #ccc
    }

    .container input:checked ~ .checkmark {
        background-color: #2196F3
    }

    .checkmark:after {
        content: \"\";
        position: absolute;
        display: none
    }

    .container input:checked ~ .checkmark:after {
        display: block
    }

    .container .checkmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white
    }
</style>
<div class=\"container mt-5\">
    <div class=\"row d-flex justify-content-center align-items-center\">
        <div class=\"col-md-6\">
            {{ form_start(form,{'attr':{'id':'regForm'}}) }}

            <h1 id=\"register\">Ajouter un Interlocuteur</h1>
            <div class=\"all-steps\" id=\"all-steps\">
                <span class=\"step\"></span>
                <span class=\"step\"></span>
                <span class=\"step\"></span>
            <div class=\"tab\">

                <h3>Type d'interlocuteur:</h3>
                {{ form_widget(form.type) }}
            </div>
            <div class=\"tab\">

                <div class=\"societe\">
                    <p>{{ form_widget(form.societe.raisonSociale) }} </p>
                    <p>{{ form_widget(form.societe.nom) }} </p>
                    <p>{{ form_widget(form.societe.siret) }} </p>
                    <p>{{ form_widget(form.societe.formeJuridique) }} </p>
                    <p>{{ form_widget(form.societe.activitePrincipale) }} </p>
                    <p>{{ form_widget(form.societe.dirigeant) }} </p>
                    <p>{{ form_widget(form.societe.dateDeCreation) }} </p>
                    <p>{{ form_widget(form.societe.email) }} </p>
                    <p>{{ form_widget(form.societe.adresse1) }} </p>
                    <p>{{ form_widget(form.societe.adresse2) }} </p>
                    <p>{{ form_widget(form.societe.ville) }} </p>
                    <p>{{ form_widget(form.societe.codePostal) }} </p>
                    <p>{{ form_widget(form.societe.pays) }} </p>

                </div>
                <div class=\"personne\">
                    <p>{{ form_widget(form.personne.nom) }} </p>
                    <p>{{ form_widget(form.personne.prenom) }} </p>
                    <p>{{ form_widget(form.personne.email) }} </p>
                    <p>{{ form_widget(form.personne.adresse1) }} </p>
                    <p>{{ form_widget(form.personne.adresse2) }} </p>
                    <p>{{ form_widget(form.personne.ville) }} </p>
                    <p>{{ form_widget(form.personne.codePostal) }} </p>
                    <p>{{ form_widget(form.personne.pays) }} </p>
                </div>
            </div>
            <div class=\"tab\">
                <p>{{ form_widget(form.commentaire) }} </p>
            </div>
            <div style=\"overflow:auto;\" id=\"nextprevious\">
                <div style=\"float:right;\">
                    <button type=\"button\" id=\"prevBtn\" onclick=\"nextPrev(-1)\">Précédent</button>
                    <button type=\"button\" id=\"nextBtn\" onclick=\"nextPrev(1)\">Suivant</button>
                </div>
            </div>
            {{ form_end(form) }}
        </div>
    </div>
</div>



<script>



    \$(\"input:radio[name='interlocuteur[type]']\").val() === \"personne\" ? \$('.personne').show() && \$('.societe').hide() && disableRequired(\"personne-form\",\"societe-form\") : \$('.personne').hide() && \$('.societe').show() && disableRequired(\"societe-form\",\"personne-form\")

    function disableRequired(actif,inactif){
       \$('.'+inactif).each(function () {
           \$(this).attr('required',false)
           console.log(\$(this).attr('class'))
       })

       \$('.'+actif).each(function () {
           if(\$(this).hasClass('required')) {
               \$(this).attr('required',true)
           }
       })
       
   }

    \$(\"input:radio[name='interlocuteur[type]']\").on(\"change\", function() {
        \$(this).val() === \"personne\" ? \$('.personne').show() && \$('.societe').hide() && disableRequired(\"personne-form\",\"societe-form\") : \$('.personne').hide() && \$('.societe').show() && disableRequired(\"societe-form\",\"personne-form\")

    })


    //your javascript goes here
    var currentTab = 0;
    document.addEventListener(\"DOMContentLoaded\", function (event) {


        showTab(currentTab);

    });

    \$('.submit').click(function (){
        \$('form').submit();
    })

    function showTab(n) {
        var x = document.getElementsByClassName(\"tab\");
        x[n].style.display = \"block\";
        if (n == 0) {
            document.getElementById(\"prevBtn\").style.display = \"none\";
        } else {
            document.getElementById(\"prevBtn\").style.display = \"inline\";
        }

        if (n == (x.length - 1)) {

            const submit =     '<button class=\"nextBtn\">{{ button_label|default('Save') }}</button>';
            \$('#nextBtn').replaceWith(submit)
        } else {
            document.getElementById(\"nextBtn\").innerHTML = \"Next\";
        }
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        var x = document.getElementsByClassName(\"tab\");
        if (n == 1 && !validateForm()) return false;
        x[currentTab].style.display = \"none\";
        currentTab = currentTab + n;
        if (currentTab >= x.length) {

            document.getElementById(\"nextprevious\").style.display = \"none\";
            document.getElementById(\"all-steps\").style.display = \"none\";
            document.getElementById(\"register\").style.display = \"none\";
            document.getElementById(\"text-message\").style.display = \"block\";


        }
        showTab(currentTab);
    }

    function validateForm() {
        var x, y, i, valid = true;
        x = document.getElementsByClassName(\"tab\");
        y = x[currentTab].getElementsByTagName(\"input\");
        for (i = 0; i < y.length; i++) {
            if (y[i].value == \"\" && y[i].required) {
                y[i].className += \" invalid\";
                valid = false;
            }
        }
        if (valid) {
            document.getElementsByClassName(\"step\")[currentTab].className += \" finish\";
        }
        return valid;
    }

    function fixStepIndicator(n) {
        var i, x = document.getElementsByClassName(\"step\");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(\" active\", \"\");
        }
        x[n].className += \" active\";
    }
</script>", "interlocuteur/interlocuteur/_form.html.twig", "/home/jqwe8986/public_html/crm_j4r/templates/interlocuteur/interlocuteur/_form.html.twig");
    }
}
