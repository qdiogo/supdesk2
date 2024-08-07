<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* display/results/show_all_checkbox.twig */
class __TwigTemplate_6e5bcc9a070724cb37ff4a994d7ed8397afe113a0c2f07e20445a78efa41687c extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<td>
    <form action=\"sql.php\" method=\"post\">
        ";
        // line 3
        echo PhpMyAdmin\Url::getHiddenInputs((isset($context["db"]) ? $context["db"] : null), (isset($context["table"]) ? $context["table"] : null));
        echo "
        <input type=\"hidden\" name=\"sql_query\" value=\"";
        // line 4
        echo (isset($context["html_sql_query"]) ? $context["html_sql_query"] : null);
        echo "\" />
        <input type=\"hidden\" name=\"pos\" value=\"0\" />
        <input type=\"hidden\" name=\"is_browse_distinct\" value=\"";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["is_browse_distinct"]) ? $context["is_browse_distinct"] : null), "html", null, true);
        echo "\" />
        <input type=\"hidden\" name=\"session_max_rows\" value=\"";
        // line 7
        (( !(isset($context["showing_all"]) ? $context["showing_all"] : null)) ? (print ("all")) : (print (twig_escape_filter($this->env, (isset($context["max_rows"]) ? $context["max_rows"] : null), "html", null, true))));
        echo "\" />
        <input type=\"hidden\" name=\"goto\" value=\"";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["goto"]) ? $context["goto"] : null), "html", null, true);
        echo "\" />
        <input type=\"checkbox\" name=\"navig\" id=\"showAll_";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["unique_id"]) ? $context["unique_id"] : null), "html", null, true);
        echo "\" class=\"showAllRows\"";
        // line 10
        echo (((isset($context["showing_all"]) ? $context["showing_all"] : null)) ? (" checked=\"checked\"") : (""));
        echo " value=\"all\" />
        <label for=\"showAll_";
        // line 11
        echo twig_escape_filter($this->env, (isset($context["unique_id"]) ? $context["unique_id"] : null), "html", null, true);
        echo "\">";
        echo _gettext("Show all");
        echo "</label>
    </form>
</td>
";
    }

    public function getTemplateName()
    {
        return "display/results/show_all_checkbox.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 11,  58 => 10,  55 => 9,  51 => 8,  47 => 7,  43 => 6,  38 => 4,  34 => 3,  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "display/results/show_all_checkbox.twig", "C:\\suporte\\GA\\phpadmin\\templates\\display\\results\\show_all_checkbox.twig");
    }
}
