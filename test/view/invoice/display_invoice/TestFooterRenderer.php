<?php
require_once('view/invoice/display_invoice/FooterRenderer.php');

class TestFooterRenderer extends PHPUnit_Framework_TestCase
{
    const UN_MONTANT_AVANT_TAXE = 110.00;
    const UN_MONTANT_DE_TVQ = 7.00;
    const UN_MONTANT_DE_TPS = 5.00;
    const UN_MONTANT_APRÈS_TAXE = 112.20;
    const UN_TAUX_DE_TPS = "4.95";
    const UN_TAUX_DE_TVQ = "9.50";
    const NOMBRE_DE_COLONES_POUR_FACTURE_DE_TEMPS = 7;


    private $content_array;

    /**
     * @before
     */
    function buildContentArray(){
        $this->content_array = array(
            'pretax_total'=>self::UN_MONTANT_AVANT_TAXE,
            'tvq_amount'=>self::UN_MONTANT_DE_TVQ,
            'tps_amount'=>self::UN_MONTANT_DE_TPS,
            'total'=>self::UN_MONTANT_APRÈS_TAXE,
            'tps_rate'=>self::UN_TAUX_DE_TPS,
            'tvq_rate'=>self::UN_TAUX_DE_TVQ,
        );
    }

    function test_givenBuiltFooterRenderer_whenRender_obtainStringofFooter()
    {
        $renderer = new FooterRenderer(self::NOMBRE_DE_COLONES_POUR_FACTURE_DE_TEMPS);
        $renderer->buildContent($this->content_array);

        $html_output = $renderer->render();

        $this->assertEquals($this->getFooterString(), $html_output);
    }

    private function getFooterString()
    {
        return '<tr height="" class=""> 
<td width="" colspan=7 valign=top class=""> 
<span class=Titre>-------------------------------------------------------------------------------------------------------------------------------------------------------</span> 
</td> 
</tr> 
<tr height="" class=""> 
<td width="" colspan=4 valign=top class=""> 
<span class=Small>#TPS : 144013992RT  #TVQ : 1087890909TQ</span> 
</td> 
<td width="" colspan=2 valign=top class=""> 
<span class=Titre><div align=right>Sous-Total: </div></span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=Titre>110.00&nbsp;$</span> 
</td> 
</tr> 
<tr height="" class=""> 
<td width="" colspan=4 valign=top class=""> 
<span class=Small>Pour tous vos besoins en produits et accessoires de piscine,</span> 
</td> 
<td width="" colspan=2 valign=top class=""> 
<span class=Titre><div align=right>TPS - 4.95%: </div></span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=Titre>5.00&nbsp;$</span> 
</td> 
</tr> 
<tr height="" class=""> 
<td width="" colspan=4 valign=top class=""> 
<span class=Small>ou services de professionnels, faites appel à</span> 
</td> 
<td width="" colspan=2 valign=top class=""> 
<span class=Titre><div align=right>TVQ - 9.50%: </div></span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=Titre>7.00&nbsp;$</span> 
</td> 
</tr> 
<tr height="" class=""> 
<td width="" colspan=4 valign=top class=""> 
<span class=Small>ENTRETIEN DE PISCINE SOUCY au (418) 872-4440.</span> 
</td> 
<td width="" colspan=3 valign=top class=""> 
<span class=Titre>--------------------------</span> 
</td> 
</tr> 
<tr height="" class=""> 
<td width="" colspan=4 valign=top class=""> 
<span class=Small>Veuillez effectuer le paiement dans les 7 jours suivant la réception de cette facture.</span> 
</td> 
<td width="" colspan=2 valign=top class=""> 
<span class=Titre><div align=right>Total: </div></span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=Titre>112.20&nbsp;$</span> 
</td> 
</tr> 
<tr height="" class=""> 
<td width="" colspan=4 valign=top class=""> 
<span class=Small> </span> 
</td> 
<td width="" colspan=2 valign=top class=""> 
<span class=texte> </span> 
</td> 
<td width="" colspan=1 valign=top class=""> 
<span class=texte> </span> 
</td> 
</tr> 
<tr height="" class=""> 
<td width="" colspan=7 valign=top class=""> 
<span class=Small><div align=center><span class="Titre">Les paiements doivent être fait à l\'ordre de Service de Sauveteurs qn inc.  </span><br>Service de Sauveteurs qn inc. 3178 chemin Ste-Foy Québec, Qc, G1X 1R4<br>tél : (418)687-4047 télec: (418) 780-3714 info@servicedesauveteurs.com</div></span> 
</td> 
</tr> 
</table> 
';
    }
}
