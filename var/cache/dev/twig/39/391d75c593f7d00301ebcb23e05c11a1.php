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

/* interlocuteur/interlocuteur/index.html.twig */
class __TwigTemplate_7ead47e339016d7898d1ff7d1ee25198 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "interlocuteur/interlocuteur/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "interlocuteur/interlocuteur/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "interlocuteur/interlocuteur/index.html.twig", 1);
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

        echo "Interlocuteur index";
        
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
        echo "
    <table class=\"table\">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>Code Postal</th>
                <th>Pays</th>
                <th>Type</th>
                <th>Siret</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
        ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["interlocuteurs"]) || array_key_exists("interlocuteurs", $context) ? $context["interlocuteurs"] : (function () { throw new RuntimeError('Variable "interlocuteurs" does not exist.', 22, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["interlocuteur"]) {
            // line 23
            echo "            <tr>
                <td><a href=\"";
            // line 24
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_interlocuteur_interlocuteur_show", ["id" => twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "id", [], "any", false, false, false, 24)]), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "id", [], "any", false, false, false, 24), "html", null, true);
            echo "</a></td>

                <td>
                    ";
            // line 27
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 27))) {
                // line 28
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 28), "nom", [], "any", false, false, false, 28), "html", null, true);
                echo "
                    ";
            } elseif ( !twig_test_empty(twig_get_attribute($this->env, $this->source,             // line 29
$context["interlocuteur"], "personne", [], "any", false, false, false, 29))) {
                // line 30
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "personne", [], "any", false, false, false, 30), "nom", [], "any", false, false, false, 30), "html", null, true);
                echo "
                    ";
            }
            // line 32
            echo "                </td>

                <td>
                    ";
            // line 35
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 35))) {
                // line 36
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 36), "adresse1", [], "any", false, false, false, 36), "html", null, true);
                echo "
                    ";
            } elseif ( !twig_test_empty(twig_get_attribute($this->env, $this->source,             // line 37
$context["interlocuteur"], "personne", [], "any", false, false, false, 37))) {
                // line 38
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "personne", [], "any", false, false, false, 38), "adresse1", [], "any", false, false, false, 38), "html", null, true);
                echo "
                    ";
            }
            // line 40
            echo "                </td>

                <td>
                    ";
            // line 43
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 43))) {
                // line 44
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 44), "ville", [], "any", false, false, false, 44), "html", null, true);
                echo "
                    ";
            } elseif ( !twig_test_empty(twig_get_attribute($this->env, $this->source,             // line 45
$context["interlocuteur"], "personne", [], "any", false, false, false, 45))) {
                // line 46
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "personne", [], "any", false, false, false, 46), "ville", [], "any", false, false, false, 46), "html", null, true);
                echo "
                    ";
            }
            // line 48
            echo "                </td>

                <td>
                    ";
            // line 51
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 51))) {
                // line 52
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 52), "codePostal", [], "any", false, false, false, 52), "html", null, true);
                echo "
                    ";
            } elseif ( !twig_test_empty(twig_get_attribute($this->env, $this->source,             // line 53
$context["interlocuteur"], "personne", [], "any", false, false, false, 53))) {
                // line 54
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "personne", [], "any", false, false, false, 54), "codePostal", [], "any", false, false, false, 54), "html", null, true);
                echo "
                    ";
            }
            // line 56
            echo "                </td>
                <td>
                    ";
            // line 58
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 58))) {
                // line 59
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 59), "pays", [], "any", false, false, false, 59), "html", null, true);
                echo "
                    ";
            } elseif ( !twig_test_empty(twig_get_attribute($this->env, $this->source,             // line 60
$context["interlocuteur"], "personne", [], "any", false, false, false, 60))) {
                // line 61
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "personne", [], "any", false, false, false, 61), "pays", [], "any", false, false, false, 61), "html", null, true);
                echo "
                    ";
            }
            // line 63
            echo "                </td>
                <td>";
            // line 64
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "type", [], "any", false, false, false, 64), "html", null, true);
            echo "</td>
                <td>
                    ";
            // line 66
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 66))) {
                // line 67
                echo "                        ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "societe", [], "any", false, false, false, 67), "siret", [], "any", false, false, false, 67), "html", null, true);
                echo "
                    ";
            } elseif ( !twig_test_empty(twig_get_attribute($this->env, $this->source,             // line 68
$context["interlocuteur"], "personne", [], "any", false, false, false, 68))) {
                // line 69
                echo "                        ";
                echo "";
                echo "
                    ";
            }
            // line 71
            echo "                </td>


                <td>";
            // line 74
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["interlocuteur"], "commentaire", [], "any", false, false, false, 74), "html", null, true);
            echo "</td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 77
            echo "            <tr>
                <td colspan=\"4\">no records found</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['interlocuteur'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 81
        echo "        </tbody>
    </table>

    <a href=\"";
        // line 84
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_interlocuteur_interlocuteur_new");
        echo "\">Create new</a>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    public function getTemplateName()
    {
        return "interlocuteur/interlocuteur/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  266 => 84,  261 => 81,  252 => 77,  244 => 74,  239 => 71,  233 => 69,  231 => 68,  226 => 67,  224 => 66,  219 => 64,  216 => 63,  210 => 61,  208 => 60,  203 => 59,  201 => 58,  197 => 56,  191 => 54,  189 => 53,  184 => 52,  182 => 51,  177 => 48,  171 => 46,  169 => 45,  164 => 44,  162 => 43,  157 => 40,  151 => 38,  149 => 37,  144 => 36,  142 => 35,  137 => 32,  131 => 30,  129 => 29,  124 => 28,  122 => 27,  114 => 24,  111 => 23,  106 => 22,  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Interlocuteur index{% endblock %}

{% block body %}

    <table class=\"table\">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>Code Postal</th>
                <th>Pays</th>
                <th>Type</th>
                <th>Siret</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
        {% for interlocuteur in interlocuteurs %}
            <tr>
                <td><a href=\"{{ path('app_interlocuteur_interlocuteur_show', {'id': interlocuteur.id}) }}\">{{ interlocuteur.id }}</a></td>

                <td>
                    {% if interlocuteur.societe is not empty %}
                        {{ interlocuteur.societe.nom }}
                    {% elseif interlocuteur.personne is not empty %}
                        {{ interlocuteur.personne.nom }}
                    {% endif %}
                </td>

                <td>
                    {% if interlocuteur.societe is not empty %}
                        {{ interlocuteur.societe.adresse1 }}
                    {% elseif interlocuteur.personne is not empty %}
                        {{ interlocuteur.personne.adresse1 }}
                    {% endif %}
                </td>

                <td>
                    {% if interlocuteur.societe is not empty %}
                        {{ interlocuteur.societe.ville }}
                    {% elseif interlocuteur.personne is not empty %}
                        {{ interlocuteur.personne.ville }}
                    {% endif %}
                </td>

                <td>
                    {% if interlocuteur.societe is not empty %}
                        {{ interlocuteur.societe.codePostal }}
                    {% elseif interlocuteur.personne is not empty %}
                        {{ interlocuteur.personne.codePostal }}
                    {% endif %}
                </td>
                <td>
                    {% if interlocuteur.societe is not empty %}
                        {{ interlocuteur.societe.pays }}
                    {% elseif interlocuteur.personne is not empty %}
                        {{ interlocuteur.personne.pays }}
                    {% endif %}
                </td>
                <td>{{ interlocuteur.type }}</td>
                <td>
                    {% if interlocuteur.societe is not empty %}
                        {{ interlocuteur.societe.siret }}
                    {% elseif interlocuteur.personne is not empty %}
                        {{ \"\" }}
                    {% endif %}
                </td>


                <td>{{ interlocuteur.commentaire }}</td>
            </tr>
        {% else %}
            <tr>
                <td colspan=\"4\">no records found</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

    <a href=\"{{ path('app_interlocuteur_interlocuteur_new') }}\">Create new</a>
{% endblock %}
", "interlocuteur/interlocuteur/index.html.twig", "/home/jqwe8986/public_html/crm_j4r/templates/interlocuteur/interlocuteur/index.html.twig");
    }
}
