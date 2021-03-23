<?php


class FooterRenderer extends HTMLContainerRenderer
{
    private $invoice_width;
    private $text_footer_width;

    function __construct($invoice_width)
    {
        $this->invoice_width = $invoice_width; #c'est 4 ou 7
        $this->number_title_width = 1;
        $this->number_footer_width = 1;
        $this->text_footer_width = $this->invoice_width - $this->number_footer_width - $this->number_title_width;
        parent::__construct();
    }

    function buildContent($content_array)
    {
        $note_in_footer = $this->getNotesInFooter();
        $tvq_rate = $content_array['tvq_rate'];
        $tps_rate = $content_array['tps_rate'];
        $pretax_total = $content_array['pretax_total'];
        $tvq_amount = $content_array['tvq_amount'];
        $tps_amount = $content_array['tps_amount'];
        $total = $content_array['total'];

        $this->html_container->OpenRow();
        $this->html_container->OpenCol('',$this->invoice_width);
        $this->html_container->AddTexte("-------------------------------------------------------------------------------------------------------------------------------------------------------",'Titre');
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();

        $this->html_container->OpenRow();
        $this->html_container->OpenCol('',$this->text_footer_width);
        $this->html_container->AddTexte($note_in_footer[0],'Small');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol('',$this->number_title_width);
        $this->html_container->AddTexte('<div align=right>Sous-Total: </div>','Titre');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol('',$this->number_footer_width);
        $this->html_container->AddTexte(number_format($pretax_total,2)."&nbsp;$",'Titre');
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();


        $this->html_container->OpenRow();
        $this->html_container->OpenCol('',$this->text_footer_width);
        $this->html_container->AddTexte($note_in_footer[1],'Small');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol('',$this->number_title_width);
        $this->html_container->AddTexte("<div align=right>TPS - ".$tps_rate."%: </div>",'Titre');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol('',$this->number_footer_width);
        $this->html_container->AddTexte(number_format($tps_amount,2)."&nbsp;$",'Titre');
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();


        $this->html_container->OpenRow();
        $this->html_container->OpenCol('',$this->text_footer_width);
        $this->html_container->AddTexte($note_in_footer[2],'Small');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol('',$this->number_title_width);
        $this->html_container->AddTexte('<div align=right>TVQ - '.$tvq_rate.'%: </div>','Titre');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol('',$this->number_footer_width);
        $this->html_container->AddTexte(number_format($tvq_amount,2)."&nbsp;$",'Titre');
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();

        $this->html_container->OpenRow();
        $this->html_container->OpenCol('',$this->text_footer_width);
        $this->html_container->AddTexte($note_in_footer[3],'Small');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol('',$this->number_title_width+$this->number_footer_width);
        $this->html_container->AddTexte("--------------------------",'Titre');
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();

        $this->html_container->OpenRow();
        $this->html_container->OpenCol('',$this->text_footer_width);
        $this->html_container->AddTexte($note_in_footer[4],'Small');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol('',$this->number_title_width);
        $this->html_container->AddTexte('<div align=right>Total: </div>','Titre');
        $this->html_container->CloseCol();
        $this->html_container->OpenCol('',$this->number_footer_width);
        $this->html_container->AddTexte(number_format($total,2)."&nbsp;$",'Titre');
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();

        $this->html_container->OpenRow();
        $this->html_container->OpenCol('',$this->invoice_width);
        $this->html_container->CloseRow();

        $this->html_container->OpenRow();
        $this->html_container->OpenCol('',$this->invoice_width);
        $this->html_container->AddTexte('<div align=center><span class="Titre">'.$note_in_footer[5].' '.$note_in_footer[6].' </span><br>'.$note_in_footer[7].'<br>'.$note_in_footer[8].'</div>','Small');
        $this->html_container->CloseCol();
        $this->html_container->CloseRow();

        $this->html_container->CloseTable();
    }

    private function getNotesInFooter()
    {
        $footer = array();
        $footer[] = "#TPS : 144013992RT  #TVQ : 1087890909TQ";
        $footer[] = "Contactez-nous pour tous vos besoins en produits et accessoires de piscine,";
        $footer[] = "ou services de professionnels";
        $footer[] = "Veuillez effectuer le paiement dans les 7 jours suivant la réception de cette facture.";
        $footer[] = "Les paiements doivent être fait à l'ordre de Service de Sauveteurs qn inc.";
        $footer[] = "";
        $footer[] = "Service de Sauveteurs qn inc. 3178 chemin Ste-Foy Québec, Qc, G1X 1R4";
        $footer[] = "tél : (418)687-4047 télec: (418) 780-3714 info@servicedesauveteurs.com";

        return $footer;
    }
}
