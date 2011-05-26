<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

if (empty($_AS['topic']))
	$_AS['topic'] = 'Article';

$plug_lang['area'] =  'Redaction';
$plug_lang['area_article'] =  $_AS['topic'];
$plug_lang['area_archive'] =  $_AS['topic'].' archivés';
$plug_lang['area_category'] =  'Catégories';
$plug_lang['area_settings'] =  'Paramètrage';

$plug_lang['action_show_article'] =  'Sommaire '.strtolower($_AS['topic']);
$plug_lang['action_show_archive'] =  'Sommaire archives';
$plug_lang['action_show_category'] =  'Gestion des catégories';
$plug_lang['action_show_settings'] =  'Paramètrage';
$plug_lang['action_new_article'] =  'Créer article';
$plug_lang['action_edit_article'] =  'Modifier';
$plug_lang['action_dupl_article'] =  'Dupliquer';

$plug_lang['new'] =  'Créer';
$plug_lang['back'] =  'Retour';
$plug_lang['saveback'] =  'Enregistrer et retour';
$plug_lang['saveback2'] =  'Sauvegarder';
$plug_lang['save'] =  'Enregistrer';
$plug_lang['cancel'] =  'Abandon';
$plug_lang['foralllangs'] =  'pour toutes les langues';
$plug_lang['dupl'] =  'Dupliquer';
$plug_lang['create'] =  'Créer';
$plug_lang['yes'] =  'Oui';
$plug_lang['no'] =  'Non';
$plug_lang['active'] =  'Activ';
$plug_lang['nonactive'] =  'Inactiv';
$plug_lang['question_delete'] =  'Vraiment supprimer?';
$plug_lang['question_reset'] =  'Vraiment reinitialiser?';
$plug_lang['question_dearchive'] = 'Vraiement dearchiver?';
$plug_lang['question_archive'] = 'Vraiment archiver?';
$plug_lang['revert_selection'] =  'Inverser sélection';
$plug_lang['delete_selected'] =  'Supprimer sélection';

$plug_lang['js_get_title1']="Modifier titre?";
$plug_lang['js_get_title2']="Reprendre titre du URL?";

$plug_lang['all'] =  'Tous';
$plug_lang['nothing_found'] =  'Aucun enregistrement trouvé.';
$plug_lang['found_error'] =  'Saisies érronés!\n Veuillez vérifier vos entrées dans le formulaire.';

$plug_lang['showrange'] =  'Lapse de temps affiché';
$plug_lang['prev'] =  '‹‹‹';
$plug_lang['next'] =  '›››';
$plug_lang['add'] =  'ajouter';

$plug_lang['start'] =  'Date début';
$plug_lang['end'] =  'Date fin';
$plug_lang['created'] =  'Créé le';
$plug_lang['title'] =  'Titre';
$plug_lang['current'] =  'Actuel';
$plug_lang['turnus'] =  'Turnus';
$plug_lang['actions'] =  'Actions';
$plug_lang['switch_online'] =  'Mettre online';
$plug_lang['switch_offline'] =  'Mettre offline';
$plug_lang['switch_archive'] =  'Archiver';
$plug_lang['switch_dearchive'] =  'Déarchiver';
$plug_lang['edit'] =  'Modifier';
$plug_lang['delete'] =  'Supprimer';
$plug_lang['hour'] =  ' heures';
$plug_lang['search'] =  'Rechercher';
$plug_lang['sort_index_input_title'] =  'Index de triage';



$plug_lang['category_filter']  =  'Filtrer la catégorie';

$plug_lang['weekday_1'] =  'Lundi';
$plug_lang['weekday_2'] =  'Mardi';
$plug_lang['weekday_3'] =  'Mercredi';
$plug_lang['weekday_4'] =  'Jeudi';
$plug_lang['weekday_5'] =  'Vendredi';
$plug_lang['weekday_6'] =  'Samedi';
$plug_lang['weekday_7'] =  'Dimanche';

$plug_lang['month_1'] =  'Janvier';
$plug_lang['month_2'] =  'Février';
$plug_lang['month_3'] =  'Mars';
$plug_lang['month_4'] =  'Avril';
$plug_lang['month_5'] =  'Mai';
$plug_lang['month_6'] =  'Juin';
$plug_lang['month_7'] =  'Juilliet';
$plug_lang['month_8'] =  'Août';
$plug_lang['month_9'] =  'Septembre';
$plug_lang['month_10'] =  'Octobre';
$plug_lang['month_11'] =  'Novembre';
$plug_lang['month_12'] =  'Décembre';

$plug_lang['day'] =  'Jour';
$plug_lang['day_plural'] =  'Jours';
$plug_lang['month'] =  'Mois';
$plug_lang['month_plural'] =  'Mois';
$plug_lang['year'] =  'An';
$plug_lang['year_plural'] =  'Ans';


$plug_lang['settings_general'] =  'Paramètre généraux';
$plug_lang['settings_set_organizer'] =  'Autoriser l`affectation des organisateurs?';
$plug_lang['settings_set_category'] =  'Autoriser l`affectation des catégories?';
$plug_lang['settings_set_category_multiple'] =  'Affecter un article à plusieurs catégories en même temps?';
$plug_lang['settings_use_archive'] =  'Utiliser l`archive des articles?';

$plug_lang['settings_number_of_month'] =  'Vue standard "Lapse de temps affiché"';
$plug_lang['settings_number_of_entries'] =  'Vue standard "Articles par page"';
$plug_lang['settings_language'] =  'Langue du système de gestion d`articles?';
$plug_lang['settings_skin'] =  'Mode d`affichage du système de gestion d`articles dans le Backend?';
$plug_lang['settings_selectbox_all'] =  '--- Tous ---';
$plug_lang['settings_yes'] =  'Oui';
$plug_lang['settings_no'] =  'Non';
$plug_lang['settings_active'] =  'Activ';
$plug_lang['settings_nonactive'] =  'Inactiv';
$plug_lang['settings_wysiwyg'] =  'Utiliser l`éditeur WYSIWYG pour le texte de l`article';
$plug_lang['settings_picture_select_folders'] = 'Sélection des images du/des répertoire(s)';
$plug_lang['settings_picture_select_subfolders'] = 'Sélection des images - inclure sous-répertoires';
$plug_lang['settings_file_select_folders'] = 'Sélection des fichiers du/des répertoire(s)';
$plug_lang['settings_file_select_subfolders'] = 'Sélection des fichiers - inclure sous-répertoires';
$plug_lang['settings_file_select_filetypes'] = 'Sélection des fichiers - limité aux types de fichiers suivants';
$plug_lang['settings_new_articles_online'] = 'Activer le crochet "Article est online" quand un nouveau article est créée?';
$plug_lang['settings_new_articles_lang_copy'] = 'Lors de la sauvegarde crééer une copie de chaque nouveau article dans toutes les langues?';
$plug_lang['settings_global_settings'] = 'Sauvegarder le paramètrage pour toutes les langues?';
$plug_lang['settings_del_all_lang_copies'] = 'Lors de la suppression, supprimer les copies de l`article dans les autres langues?';


for ($i=1;$i<36;$i++){
	$plug_lang['article_settings_custom'.$i] =  'Zone définissable '.$i;
}
$plug_lang['article_settings_custom_label'] =  'Description<small> (vide = zone inactive)</small>';
$plug_lang['article_settings_custom_values'] =  'Valuers<small> (une ligne = une valeur)</small>';

$plug_lang['article_settings_general'] =  'Éléments de l`article';
$plug_lang['article_settings_file1'] ='Fichier(s)';
$plug_lang['article_settings_picture1'] ='Image(s)';
$plug_lang['article_settings_link'] ='Lien(s)';
$plug_lang['article_settings_date'] ='Date(s) limite';
$plug_lang['article_settings_desc_input'] ='Avec description';
$plug_lang['article_settings_link_input'] ='Avec lien image';
$plug_lang['article_settings_no_input'] ='Nombre <small>(0 = quelconque)</small>';

$plug_lang['article_settings_text'] ='Texte';
$plug_lang['article_settings_teaser'] ='Teaser <small>("accroche-oeil")</small>';

$plug_lang['category'] =  'Catégories';
$plug_lang['category_delete'] =  'Supprimer catégorie?';
$plug_lang['category_create'] =  'Nouvelle catégorie';

$plug_lang['article_elements_sel'] =  'sélection';
$plug_lang['article_elements_del'] =  'supprimer';

$plug_lang['article_langcopyfrom'] =  'Reprendre le contenu de ...';
$plug_lang['article_online'] =  'Online';
$plug_lang['article_online_desc'] =  'Article est online';
$plug_lang['article_article_start'] =  'Date début';
$plug_lang['article_article_end'] =  'Date fin';
$plug_lang['article_article_weekday'] =  'Article jour de semaine';
$plug_lang['article_category'] =  'Catégorie';
$plug_lang['article_title'] =  'Titre';
$plug_lang['article_teaser'] =  'Accroche-oeil';
$plug_lang['article_text'] =  'Texte';
$plug_lang['article_pictures'] =  'Image(s)';
$plug_lang['article_picture'] =  'Image';
$plug_lang['article_picture_link'] =  'Lien-image';
$plug_lang['article_picture1_description'] =  'Description image';
$plug_lang['article_picture1_title'] =  'Titre image';
$plug_lang['article_link'] =  'Lien(s)';
$plug_lang['article_link_url'] =  'Lien-URL';
$plug_lang['article_link_title'] =  'Titre lien';
$plug_lang['article_link_description'] =  'Description lien';
$plug_lang['article_date'] =  'Dates limite';
$plug_lang['article_date_date'] =  'Date';
$plug_lang['article_date_time'] =  'Heure';
$plug_lang['article_date_duration'] =  'Durée';
$plug_lang['article_date_title'] =  'Titre date limite';
$plug_lang['article_date_description'] =  'Description date limite';

$plug_lang['article_files'] =  'Fichier(s)';
$plug_lang['article_file'] =  'Fichier';
$plug_lang['article_file1_title'] =  'Titre fichier';
$plug_lang['article_file1_description'] =  'Description fichier';
$plug_lang['article_non_selected_string'] =  '--- Sélection ---';
$plug_lang['article_copy'] =  'Kopie';

$plug_lang['article_settings_custom_type_text']='Zone texte - une ligne';
$plug_lang['article_settings_custom_type_textarea']='Zone texte - plusieurs lignes';
$plug_lang['article_settings_custom_type_wysiwyg']='Zone texte - plusieurs lignes (formatable)';
$plug_lang['article_settings_custom_type_date']='Date';
$plug_lang['article_settings_custom_type_time']='Heure';
$plug_lang['article_settings_custom_type_select']='Sélection de valeurs';
$plug_lang['article_settings_custom_type_select2']='Saisie et sélection de valeurs';
$plug_lang['article_settings_custom_type_multiselect']='Sélection multiple de valeurs';

$plug_lang['article_organizer'] =  'Organisateur';

$plug_lang['article_error_to_small_enddate'] =  'La date fin est inférieure à la date début.';
$plug_lang['article_error_to_small_endtime'] =  'L`heure fin est inférieure à l`heure début.';
$plug_lang['article_error_title_empty'] =  'Le titre manque.';
$plug_lang['article_error_text_empty'] =  'Le texte manque.';
$plug_lang['article_error_empty_field'] =  'Zone obligatoire!';

$plug_lang['article_settings_valid_true'] =  'Valider: Oui';
$plug_lang['article_settings_valid_false'] =  'Valider: Non';



?>
