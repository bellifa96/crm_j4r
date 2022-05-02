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

/* entite/sous_entite/show.html.twig */
class __TwigTemplate_33856eb53e8ee1352ce3631fe120c89a extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "entite/sous_entite/show.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "entite/sous_entite/show.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "entite/sous_entite/show.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "SousEntite";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    // line 5
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        echo "    <h1>SousEntite</h1>

    <table class=\"table\">
        <tbody>
            <tr>
                <th>Id</th>
                <td>";
        // line 12
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 12, $this->source); })()), "id", [], "any", false, false, false, 12), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Nom</th>
                <td>";
        // line 16
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 16, $this->source); })()), "nom", [], "any", false, false, false, 16), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>RaisonSociale</th>
                <td>";
        // line 20
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 20, $this->source); })()), "raisonSociale", [], "any", false, false, false, 20), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Siret</th>
                <td>";
        // line 24
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 24, $this->source); })()), "siret", [], "any", false, false, false, 24), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Dirigeant</th>
                <td>";
        // line 28
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 28, $this->source); })()), "dirigeant", [], "any", false, false, false, 28), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>DateDeCreation</th>
                <td>";
        // line 32
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 32, $this->source); })()), "dateDeCreation", [], "any", false, false, false, 32), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>FormeJuridique</th>
                <td>";
        // line 36
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 36, $this->source); })()), "formeJuridique", [], "any", false, false, false, 36), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>ActivitePrincipale</th>
                <td>";
        // line 40
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 40, $this->source); })()), "activitePrincipale", [], "any", false, false, false, 40), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>";
        // line 44
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 44, $this->source); })()), "type", [], "any", false, false, false, 44), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>CreatedAt</th>
                <td>";
        // line 48
        ((twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 48, $this->source); })()), "createdAt", [], "any", false, false, false, 48)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 48, $this->source); })()), "createdAt", [], "any", false, false, false, 48), "Y-m-d H:i:s"), "html", null, true))) : (print ("")));
        echo "</td>
            </tr>
            <tr>
                <th>UpdatedAt</th>
                <td>";
        // line 52
        ((twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 52, $this->source); })()), "updatedAt", [], "any", false, false, false, 52)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 52, $this->source); })()), "updatedAt", [], "any", false, false, false, 52), "Y-m-d H:i:s"), "html", null, true))) : (print ("")));
        echo "</td>
            </tr>
            <tr>
                <th>Adresse1</th>
                <td>";
        // line 56
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 56, $this->source); })()), "adresse1", [], "any", false, false, false, 56), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Adresse2</th>
                <td>";
        // line 60
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 60, $this->source); })()), "adresse2", [], "any", false, false, false, 60), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Ville</th>
                <td>";
        // line 64
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 64, $this->source); })()), "ville", [], "any", false, false, false, 64), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>CodePostal</th>
                <td>";
        // line 68
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 68, $this->source); })()), "codePostal", [], "any", false, false, false, 68), "html", null, true);
        echo "</td>
            </tr>
            <tr>
                <th>Pays</th>
                <td>";
        // line 72
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 72, $this->source); })()), "pays", [], "any", false, false, false, 72), "html", null, true);
        echo "</td>
            </tr>
        </tbody>
    </table>

    <a href=\"";
        // line 77
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_entite_sous_entite_index");
        echo "\">back to list</a>

    <a href=\"";
        // line 79
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_entite_sous_entite_edit", ["id" => twig_get_attribute($this->env, $this->source, (isset($context["sous_entite"]) || array_key_exists("sous_entite", $context) ? $context["sous_entite"] : (function () { throw new RuntimeError('Variable "sous_entite" does not exist.', 79, $this->source); })()), "id", [], "any", false, false, false, 79)]), "html", null, true);
        echo "\">edit</a>

    ";
        // line 81
        echo twig_include($this->env, $context, "entite/sous_entite/_delete_form.html.twig");
        echo "
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    public function getTemplateName()
    {
        return "entite/sous_entite/show.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  219 => 81,  214 => 79,  209 => 77,  201 => 72,  194 => 68,  187 => 64,  180 => 60,  173 => 56,  166 => 52,  159 => 48,  152 => 44,  145 => 40,  138 => 36,  131 => 32,  124 => 28,  117 => 24,  110 => 20,  103 => 16,  96 => 12,  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}SousEntite{% endblock %}

{% block body %}
    <h1>SousEntite</h1>

    <table class=\"table\">
        <tbody>
            <tr>
                <th>Id</th>
                <td>{{ sous_entite.id }}</td>
            </tr>
            <tr>
                <th>Nom</th>
                <td>{{ sous_entite.nom }}</td>
            </tr>
            <tr>
                <th>RaisonSociale</th>
                <td>{{ sous_entite.raisonSociale }}</td>
            </tr>
            <tr>
                <th>Siret</th>
                <td>{{ sous_entite.siret }}</td>
            </tr>
            <tr>
                <th>Dirigeant</th>
                <td>{{ sous_entite.dirigeant }}</td>
            </tr>
            <tr>
                <th>DateDeCreation</th>
                <td>{{ sous_entite.dateDeCreation }}</td>
            </tr>
            <tr>
                <th>FormeJuridique</th>
                <td>{{ sous_entite.formeJuridique }}</td>
            </tr>
            <tr>
                <th>ActivitePrincipale</th>
                <td>{{ sous_entite.activitePrincipale }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ sous_entite.type }}</td>
            </tr>
            <tr>
                <th>CreatedAt</th>
                <td>{{ sous_entite.createdAt ? sous_entite.createdAt|date('Y-m-d H:i:s') : '' }}</td>
            </tr>
            <tr>
                <th>UpdatedAt</th>
                <td>{{ sous_entite.updatedAt ? sous_entite.updatedAt|date('Y-m-d H:i:s') : '' }}</td>
            </tr>
            <tr>
                <th>Adresse1</th>
                <td>{{ sous_entite.adresse1 }}</td>
            </tr>
            <tr>
                <th>Adresse2</th>
                <td>{{ sous_entite.adresse2 }}</td>
            </tr>
            <tr>
                <th>Ville</th>
                <td>{{ sous_entite.ville }}</td>
            </tr>
            <tr>
                <th>CodePostal</th>
                <td>{{ sous_entite.codePostal }}</td>
            </tr>
            <tr>
                <th>Pays</th>
                <td>{{ sous_entite.pays }}</td>
            </tr>
        </tbody>
    </table>

    <a href=\"{{ path('app_entite_sous_entite_index') }}\">back to list</a>

    <a href=\"{{ path('app_entite_sous_entite_edit', {'id': sous_entite.id}) }}\">edit</a>

    {{ include('entite/sous_entite/_delete_form.html.twig') }}
{% endblock %}
", "entite/sous_entite/show.html.twig", "/home/ouss/crm_j4r/templates/entite/sous_entite/show.html.twig");
    }
}
