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

/* user/_form.html.twig */
class __TwigTemplate_057f8857f447383244317ded333f0fc9 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "user/_form.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "user/_form.html.twig"));

        // line 1
        echo "<div class=\"mb-3\">

    ";
        // line 3
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 3, $this->source); })()), 'form_start');
        echo "


    <div class=\"col-md-12\">
        <div class=\"row mb-3\">
            <div class=\"col-md-6\">
                ";
        // line 9
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 9, $this->source); })()), "firstname", [], "any", false, false, false, 9), 'widget', ["attr" => ["class" => "form-control form-control-xl", "autocomplete" => "off", "required" => "true", "placeholder" => "Nom"]]);
        echo "
            </div>
            <div class=\"col-md-6\">
                ";
        // line 12
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 12, $this->source); })()), "lastname", [], "any", false, false, false, 12), 'widget', ["attr" => ["class" => "form-control form-control-xl", "autocomplete" => "off", "required" => "true", "placeholder" => "Prénom"]]);
        echo "
            </div>
        </div>

        <div class=\"row mb-3\">
            <div class=\"col-md-6\">
                ";
        // line 18
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 18, $this->source); })()), "email", [], "any", false, false, false, 18), 'widget', ["attr" => ["class" => "form-control form-control-xl", "autocomplete" => "off", "required" => "true", "placeholder" => "Email"]]);
        echo "
            </div>
            <div class=\"col-md-6\">
                ";
        // line 21
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 21, $this->source); })()), "password", [], "any", false, false, false, 21), 'widget', ["attr" => ["class" => "form-control form-control-xl", "autocomplete" => "off", "required" => "true", "placeholder" => "Mot de passe"]]);
        echo "
            </div>
        </div>

        <div class=\"row mb-3\">
            <div class=\"col-md-6\">
                ";
        // line 27
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 27, $this->source); })()), "roles", [], "any", false, false, false, 27), 'widget', ["attr" => ["class" => "form-control form-control-xl", "autocomplete" => "off", "required" => "true", "placeholder" => "Email"]]);
        echo "
            </div>

        </div>

    </div>
    <div class=\"form-group position-relative has-icon-left mb-4\">

    </div>


    <button class=\"btn btn-success\">";
        // line 38
        echo twig_escape_filter($this->env, ((array_key_exists("button_label", $context)) ? (_twig_default_filter((isset($context["button_label"]) || array_key_exists("button_label", $context) ? $context["button_label"] : (function () { throw new RuntimeError('Variable "button_label" does not exist.', 38, $this->source); })()), "Save")) : ("Save")), "html", null, true);
        echo "</button>
    ";
        // line 39
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock((isset($context["form"]) || array_key_exists("form", $context) ? $context["form"] : (function () { throw new RuntimeError('Variable "form" does not exist.', 39, $this->source); })()), 'form_end');
        echo "

</div>";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    public function getTemplateName()
    {
        return "user/_form.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 39,  100 => 38,  86 => 27,  77 => 21,  71 => 18,  62 => 12,  56 => 9,  47 => 3,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<div class=\"mb-3\">

    {{ form_start(form) }}


    <div class=\"col-md-12\">
        <div class=\"row mb-3\">
            <div class=\"col-md-6\">
                {{ form_widget(form.firstname,{'attr':{'class':'form-control form-control-xl','autocomplete':'off','required':'true','placeholder':'Nom'}}) }}
            </div>
            <div class=\"col-md-6\">
                {{ form_widget(form.lastname,{'attr':{'class':'form-control form-control-xl','autocomplete':'off','required':'true','placeholder':'Prénom'}}) }}
            </div>
        </div>

        <div class=\"row mb-3\">
            <div class=\"col-md-6\">
                {{ form_widget(form.email,{'attr':{'class':'form-control form-control-xl','autocomplete':'off','required':'true','placeholder':'Email'}}) }}
            </div>
            <div class=\"col-md-6\">
                {{ form_widget(form.password,{'attr':{'class':'form-control form-control-xl','autocomplete':'off','required':'true','placeholder':'Mot de passe'}}) }}
            </div>
        </div>

        <div class=\"row mb-3\">
            <div class=\"col-md-6\">
                {{ form_widget(form.roles,{'attr':{'class':'form-control form-control-xl','autocomplete':'off','required':'true','placeholder':'Email'}}) }}
            </div>

        </div>

    </div>
    <div class=\"form-group position-relative has-icon-left mb-4\">

    </div>


    <button class=\"btn btn-success\">{{ button_label|default('Save') }}</button>
    {{ form_end(form) }}

</div>", "user/_form.html.twig", "/home/jqwe8986/public_html/crm_j4r/templates/user/_form.html.twig");
    }
}
