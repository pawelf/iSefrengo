<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
	die('NO CONFIGFILE FOUND');
}

if (empty($_AS['topic']))
	$_AS['topic'] = 'Artikel';

$plug_lang['area'] =  'Redaktion';
$plug_lang['area_article'] =  $_AS['topic'];
$plug_lang['area_archive'] =  $_AS['topic'].'-Archiv';
$plug_lang['area_category'] =  'Kategorien';
$plug_lang['area_settings'] =  'Einstellungen';

$plug_lang['action_show_article'] =  $_AS['topic'].'übersicht';
$plug_lang['action_show_archive'] =  'Archivübersicht';
$plug_lang['action_show_category'] =  'Kategorieverwaltung';
$plug_lang['action_show_settings'] =  'Einstellungen';
$plug_lang['action_new_article'] =  'Neu';
$plug_lang['action_edit_article'] =  'Bearbeiten';
$plug_lang['action_dupl_article'] =  'Duplizieren';

$plug_lang['new'] =  'Neu';
$plug_lang['back'] =  'Zur&uuml;ck';
$plug_lang['saveback'] =  'Übernehmen und Zurück';
$plug_lang['saveback2'] =  'Speichern';
$plug_lang['save'] =  'Übernehmen';
$plug_lang['cancel'] =  'Abbrechen';
$plug_lang['foralllangs'] =  'für alle Sprachen';
$plug_lang['dupl'] =  'Duplizieren';
$plug_lang['create'] =  'Anlegen';
$plug_lang['yes'] =  'Ja';
$plug_lang['no'] =  'Nein';
$plug_lang['active'] =  'Aktiv';
$plug_lang['nonactive'] =  'Inaktiv';
$plug_lang['question_delete'] =  'Wirklich löschen?';
$plug_lang['question_reset'] =  'Wirklich zurücksetzen?';
$plug_lang['question_dearchive'] = 'Wirklich dearchivieren?';
$plug_lang['question_archive'] = 'Wirklich archivieren?';
$plug_lang['revert_selection'] =  'Auswahl umkehren';
$plug_lang['delete_selected'] =  'Ausgewählte löschen';
$plug_lang['upload'] =  'Upload';

$plug_lang['js_get_title1']="Titel anpassen?";
$plug_lang['js_get_title2']="Titel aus URL übernehmen?";

$plug_lang['all'] =  'Alle';
$plug_lang['nothing_found'] =  'Keinen Eintrag gefunden.';
$plug_lang['found_error'] =  'Fehlerhafte Eingaben!\n Überprüfen Sie das Formular.';

$plug_lang['showrange'] =  'Angezeigter Zeitraum';
$plug_lang['prev'] =  '‹‹‹';
$plug_lang['next'] =  '›››';
$plug_lang['add'] =  'hinzufügen';

$plug_lang['start'] =  'Gültig ab';
$plug_lang['end'] =  'Gültig bis';
$plug_lang['created'] =  'Erstellt';
$plug_lang['title'] =  'Titel';
$plug_lang['current'] =  'Aktuell';
$plug_lang['turnus'] =  'Turnus';
$plug_lang['actions'] =  'Aktionen';
$plug_lang['switch_online'] =  'Online schalten';
$plug_lang['switch_offline'] =  'Offline schalten';
$plug_lang['switch_archive'] =  'Archivieren';
$plug_lang['switch_dearchive'] =  'Dearchivieren';
$plug_lang['edit'] =  'Bearbeiten';
$plug_lang['delete'] =  'L&ouml;schen';
$plug_lang['notdeletable'] =  'Löschen nicht möglich.';
$plug_lang['hour'] =  ' Uhr';
$plug_lang['search'] =  'Suchen';
$plug_lang['sort_index_input_title'] =  'Sortierungsindex';


$plug_lang['category_filter']  =  'Kategorie filtern';
$plug_lang['filter']  =  'filtern';

$plug_lang['weekday_1'] =  'Montag';
$plug_lang['weekday_2'] =  'Dienstag';
$plug_lang['weekday_3'] =  'Mittwoch';
$plug_lang['weekday_4'] =  'Donnerstag';
$plug_lang['weekday_5'] =  'Freitag';
$plug_lang['weekday_6'] =  'Samstag';
$plug_lang['weekday_7'] =  'Sonntag';

$plug_lang['month_1'] =  'Januar';
$plug_lang['month_2'] =  'Februar';
$plug_lang['month_3'] =  'März';
$plug_lang['month_4'] =  'April';
$plug_lang['month_5'] =  'Mai';
$plug_lang['month_6'] =  'Juni';
$plug_lang['month_7'] =  'Juli';
$plug_lang['month_8'] =  'August';
$plug_lang['month_9'] =  'September';
$plug_lang['month_10'] =  'Oktober';
$plug_lang['month_11'] =  'November';
$plug_lang['month_12'] =  'Dezember';

$plug_lang['day'] =  'Tag';
$plug_lang['day_plural'] =  'Tage';
$plug_lang['month'] =  'Monat';
$plug_lang['month_plural'] =  'Monate';
$plug_lang['year'] =  'Jahr';
$plug_lang['year_plural'] =  'Jahre';

$plug_lang['settings_admin_delete']='Im aktuellen Projekt löschen';
$plug_lang['settings_admin_delete_confirm1']='Soll dieses Artikelsystem ---> {dbstr}\ninkl. Datenbestand IM AKTUELLEN PROJEKT wirklich GELÖSCHT werden?';
$plug_lang['settings_admin_delete_confirm2']='Der Vorgang ist kann nicht rückgängig gemacht werden!\n\nWirklich fortfahren?';
$plug_lang['settings_admin_delete2']='Vollständig löschen';
$plug_lang['settings_admin_delete2_confirm1']='Soll dieses Artikelsystem ---> {dbstr}\ninkl. dem gesamten Datenbestand AUS ALLEN PROJEKTEN wirklich GELÖSCHT werden?';
$plug_lang['settings_admin_new_backend']='Im aktuellen Projekt installieren';
$plug_lang['settings_admin_new']='Neue Datenbank anlegen';
$plug_lang['settings_admin']='Artikelsystem - Datenbank- und Installationsverwaltung';
$plug_lang['settings_admin_general']='Artikelsysteme';
$plug_lang['settings_admin_asdb']='DATENBANK (Artikelsystem)';
$plug_lang['settings_admin_section_new_backend']='Neues Artikelsystem für aktuelles Projekt';
$plug_lang['settings_admin_section_new_backend_title']='Menüpunt-Bezeichnung für alle Sprachen';
$plug_lang['settings_admin_section_new']='Neue Datenbank';
$plug_lang['settings_admin_notice']='<strong>Wichtiger Hinweis:</strong><br/>Bitte beachten Sie, dass Sie, bevor Sie das Artikelsystem-Plugin<br/>über den Menüpunkt "Administration > Plugins" deinstallieren,<br/>alle hier befindlichen zusätzlichen Artikelsysteme löschen müssen!';


$plug_lang['settings_general'] =  'Allgemeine Einstellungen';
$plug_lang['settings_specialfunctions'] =  'Spezielle Funktionen';
$plug_lang['settings_set_category'] =  'Kategorien zuweisen erm&ouml;glichen?';
$plug_lang['settings_use_categories_rm'] =  'Kategorien Benutzergruppen zuweisen?';
$plug_lang['settings_set_category_multiple'] =  'Artikel mehreren Kategorien gleichzeitig zuweisen?';
$plug_lang['settings_use_archive'] =  'Artikel-Archiv verwenden?';
$plug_lang['settings_show_articles_pages_dir'] =  'Seitenschaltung der Artikelübersicht in umgekehrter Reihenfolge? ';

$plug_lang['settings_number_of_month'] =  'Standardansicht "Angezeigter Zeitraum"';
$plug_lang['settings_number_of_entries'] =  'Standardansicht "Artikel pro Seite"';
$plug_lang['settings_language'] =  'Sprache des Artikelsystems?';
$plug_lang['settings_skin'] =  'Aussehen des Artikelsystems im Backend?';
$plug_lang['settings_selectbox_all'] =  '--- Alle ---';
$plug_lang['settings_yes'] =  'Ja';
$plug_lang['settings_no'] =  'Nein';
$plug_lang['settings_active'] =  'Aktiv';
$plug_lang['settings_nonactive'] =  'Inaktiv';
$plug_lang['settings_wysiwyg'] =  'WYSIWYG-Editor für Artikeltext verwenden';
$plug_lang['settings_picture_select_folders'] = 'Bildauswahl - aus (den) Verzeichnis(en)';
$plug_lang['settings_picture_select_subfolders'] = 'Bildauswahl - inkl. Unterverzeichnissen';
$plug_lang['settings_file_select_folders'] = 'Dateiauswahl - aus (den) Verzeichnis(en)';
$plug_lang['settings_file_select_subfolders'] = 'Dateiauswahl - inkl. Unterverzeichnissen';
$plug_lang['settings_file_select_filetypes'] = 'Dateiauswahl - nur folgende Dateitypen';
$plug_lang['settings_new_articles_online'] = 'Häkchen "Artikel ist online" setzen wenn ein neuer Artikel angelegt wird?';
$plug_lang['settings_new_articles_lang_copy'] = 'Beim Speichern eines neuen Artikels Kopien des Artikels in allen Sprachen anlegen?';
$plug_lang['settings_global_settings'] = 'Sprachübergreifendes Speichern der Einstellungen?';
$plug_lang['settings_del_all_lang_copies'] = 'Löschen eines Artikels auf Kopien des Artikels in den anderen Sprachen anwenden?';

$plug_lang['settings_link_show_title_input'] = 'Links - Eingabe eines Link-Titels ermöglichen?';	
$plug_lang['settings_link_select_idcats'] = 'Links (int. Seiten) - Kategorieeinschränkungen <br/><small>(Idcats mit Komma voneinander getrennt eingeben. Keine Angabe = alle auswählbar.)</small>';	
$plug_lang['settings_link_select_subcats'] = 'Links (int. Seiten) - Unterkategorien anzeigen?';
$plug_lang['settings_link_select_startpages'] = 'Links (int. Seiten) - Startseiten anzeigen?';
$plug_lang['settings_link_select_showpages'] = 'Links (int. Seiten) - Seiten anzeigen?';
$plug_lang['settings_link_select_choosecats'] = 'Links (int. Seiten) - Kategorien auswählbar?';

$plug_lang['settings_lv_show_search'] = 'Volltextsuche in der Artikelübersicht anzeigen?';
$plug_lang['settings_lv_show_range'] = 'Angezeigten Zeitraum in der Artikelübersicht anzeigen?';
$plug_lang['settings_lv_show_catfilter'] = 'Kategoriefilter in der Artikelübersicht anzeigen?';
$plug_lang['settings_lv_customfilter'] = 'Freifeldfilter in der Artikelübersicht <br/><small><strong>DATENFELD(ER) untereinander eingeben</strong><br/><br/>custom1-35</small>';
$plug_lang['settings_lv_show_datetime'] = 'Artikelgültigkeit in der Artikelübersicht anzeigen?';
$plug_lang['settings_lv_show_onoffline'] = 'Artikel aktivieren/deaktivieren in der Artikelübersicht anzeigen?';
$plug_lang['settings_lv_sorting'] = 'Sortierung der Artikelübersicht<br/><small><strong>DATENFELD </strong>(s.u.) > <strong>SORTIERUNG</strong> (ASC = aufsteigend, DESC = Absteigend)<br/><br/>startdate starttime enddate endtime created lastedit title teaser text custom1-35</small>';
$plug_lang['settings_lv_fields'] = 'Anzuzeigende Felder in der Artikelübersicht <br/><small><strong>DATENFELD(ER) untereinander eingeben</strong><br/>Optional Angabe der Spaltenbreite (in Prozent) möglich: DATENFELD||BREITE<br/><br/>title teaser text custom1-35</small>';

$plug_lang['settings_backend_menu_string'] = 'Bezeichnung für Sefrengo-Backend-Menüeintrag';

for ($i=1;$i<36;$i++){
	$plug_lang['article_settings_custom'.$i] =  'Frei definierbares Feld '.$i;
	$plug_lang['article_custom'.$i] =  'Freifeld '.$i;
}
$plug_lang['article_settings_custom_label'] =  'Titel<small> (leer = inaktiv)</small>';
$plug_lang['article_settings_custom_alias'] =  'Element-Alias';
$plug_lang['article_settings_custom_type'] =  'Typ';
$plug_lang['article_settings_custom_validation'] =  'Validierung';
$plug_lang['article_settings_custom_values'] =  'Werte <small>(eine Zeile = ein Wert - Alternativ: Wert||Bezeichnung)<br/><br/>Bei den Typen Check- & Radiobox generiert jeder Wert<br/>bzw. jede Zeile eine Auswahlmöglichkeit!</small>';
$plug_lang['article_settings_custom_value'] =  'Wert';
$plug_lang['article_settings_custom_value_default'] =  'Vorgabewert bei neuem Artikel';
$plug_lang['article_settings_custom_value_default_select'] = 'Vorausgewählte Werte (eine Zeile = ein Wert - wie oben)';
$plug_lang['article_settings_custom_multi_select'] = 'Mehrfachauswahl';
$plug_lang['article_settings_custom_vmode_defcopy']='Beim Duplizieren Standard-Wert setzen';
$plug_lang['article_settings_custom_vmode']='Element-Wertverhalten';

$plug_lang['article_settings_elements'] =  'Artikelelemente';
$plug_lang['article_settings_general'] =  'Allgemeines';
$plug_lang['article_settings_elements_options'] =  'Elementoptionen';
$plug_lang['article_settings_elements_active'] =  'Aktiviert / Deaktiviert';
$plug_lang['article_settings_elements_validation'] =  'Validierung';
$plug_lang['article_settings_element_label'] ='Titel <small>(optional)</small>';
$plug_lang['article_settings_files'] ='Datei(en)';
$plug_lang['article_settings_file_upload'] = 'Mit Datei-Upload';
$plug_lang['article_settings_file_upload_folders'] = 'Datei-Upload - in (die) Verzeichnis(e)';
$plug_lang['article_settings_pictures'] ='Bild(er)';
$plug_lang['article_settings_picture_upload'] = 'Mit Bild-Upload';
$plug_lang['article_settings_picture_upload_folders'] = 'Bild-Upload - in (die) Verzeichnis(e)';
$plug_lang['article_settings_links'] ='Link(s)';
$plug_lang['article_settings_dates'] ='Termin(e)';
$plug_lang['article_settings_dates_duration'] ='Mit Dauerangabe';
$plug_lang['article_settings_dates_time'] ='Mit Zeitangabe';
$plug_lang['article_settings_desc_input'] ='Mit Beschreibung';
$plug_lang['article_settings_default_values'] ='Wertangaben';
$plug_lang['article_settings_link_input'] ='Mit Bild-Link';
$plug_lang['article_settings_no_input'] ='Anzahl <small>(0 = beliebig)</small>';
$plug_lang['article_settings_max_number_files_select'] ='Ab wievielen Dateien soll die Bild-/Dateiauswahl nur über den Resource-Browser zur Verfügung stehen?';
$plug_lang['article_settings_max_number_use_rb'] ='Bitte nutzen Sie zur Auswahl die Schaltfläche [ ... ]';



$plug_lang['article_settings_text'] ='Text';
$plug_lang['article_settings_teaser'] ='Teaser <small>("Aufmacher")</small>';

$plug_lang['category'] =  'Kategorien';
$plug_lang['category_delete'] =  'Kategorie l&ouml;schen?';
$plug_lang['category_create'] =  'Neue Kategorie';

$plug_lang['article_elements_sel'] =  'markierte';
$plug_lang['article_elements_del'] =  'löschen';

$plug_lang['article_langcopyfrom'] =  'Inhalte übernehmen aus ...';
$plug_lang['article_online'] =  'Online';
$plug_lang['article_online_desc'] =  'Artikel ist online';
$plug_lang['article_article_start'] =  'Gültig ab';
$plug_lang['article_article_end'] =  'Gültig bis';
$plug_lang['article_article_weekday'] =  'Artikel Wochentag';
$plug_lang['article_category'] =  'Kategorie';
$plug_lang['article_title'] =  'Titel';
$plug_lang['article_teaser'] =  'Aufmacher';
$plug_lang['article_text'] =  'Text';
$plug_lang['article_pictures'] =  'Bild(er)';
$plug_lang['article_picture'] =  'Bild';
$plug_lang['article_picture_link'] =  'Bild-Link';
$plug_lang['article_picture1_description'] =  'Bildbeschreibung';
$plug_lang['article_picture_upload'] =  'Bild-Upload';
$plug_lang['article_picture1_title'] =  'Bildtitel';
$plug_lang['article_links'] =  'Link(s)';
$plug_lang['article_link_url'] =  'Link-URL';
$plug_lang['article_link_title'] =  'Linktitel';
$plug_lang['article_link_description'] =  'Linkbeschreibung';
$plug_lang['article_dates'] =  'Termin(e)';
$plug_lang['article_date_date'] =  'Datum';
$plug_lang['article_date_time'] =  'Zeit';
$plug_lang['article_date_duration'] =  'Dauer';
$plug_lang['article_date_title'] =  'Termintitel';
$plug_lang['article_date_description'] =  'Terminbeschreibung';

$plug_lang['article_files'] =  'Datei(en)';
$plug_lang['article_file'] =  'Datei';
$plug_lang['article_file_upload'] =  'Datei-Upload';
$plug_lang['article_file1_title'] =  'Dateititel';
$plug_lang['article_file1_description'] =  'Dateibeschreibung';
$plug_lang['article_non_selected_string'] =  '--- Auswahl ---';
$plug_lang['article_copy'] =  'Kopie';

$plug_lang['article_settings_custom_type_text']='Einzeiliges Textfeld';
$plug_lang['article_settings_custom_type_textarea']='Mehrzeiliges Textfeld';
$plug_lang['article_settings_custom_type_wysiwyg']='Mehrzeiliges Textfeld (formatierbar)';
$plug_lang['article_settings_custom_type_select']='Auswahl von Werten';
$plug_lang['article_settings_custom_type_select2']='Eingabe und Auswahl von Werten';
$plug_lang['article_settings_custom_type_check']='Checkbox';
$plug_lang['article_settings_custom_type_radio']='Radio';
$plug_lang['article_settings_custom_type_date']='Datum';
$plug_lang['article_settings_custom_type_time']='Zeit';
$plug_lang['article_settings_custom_type_pic']='Bild';
$plug_lang['article_settings_custom_type_file']='Datei';
$plug_lang['article_settings_custom_type_link']='Link';
$plug_lang['article_settings_custom_type_info']='Infotext (keine Eingabe)';


$plug_lang['article_error_to_small_enddate'] =  'Das Enddatum ist kleiner als das Startdatum.';
$plug_lang['article_error_to_small_endtime'] =  'Die Endzeit ist kleiner als die Startzeit.';
$plug_lang['article_error_title_empty'] =  'Es ist kein Titel vorhanden.';
$plug_lang['article_error_text_empty'] =  'Es ist keine Text vorhanden.';
$plug_lang['article_error_empty_field'] =  'Pflichtangabe!';

$plug_lang['article_settings_valid_true'] =  'Nicht leer';
$plug_lang['article_settings_valid_false'] =  'Keine';
$plug_lang['article_settings_valid_regexp'] =  'RegExp';
$plug_lang['article_settings_valid_settings'] =  'Validierungs-Einstellungen';
$plug_lang['article_settings_valid_errmsg'] =  'Fehlermeldungen';
$plug_lang['article_settings_valid_regexp'] =  'Reg.-Audrücke';


$plug_lang['module_artsel_archived'] =  'arc';
$plug_lang['module_artsel_offline'] =  'off';
$plug_lang['module_artsel_online'] =  'on';


$plug_lang['err_0703'] = 'Datei konnte nicht auf den Server geladen werden.';
$plug_lang['err_0705'] = 'Dieser Dateityp ist nicht zugelassen.';
$plug_lang['err_0706'] = 'Das Zielverzeichnis wurde nicht gefunden.';
$plug_lang['err_1421'] = 'Upload gescheitert!';
$plug_lang['err_1420'] = 'Dateiname enth&auml;lt unzul&auml;ssige Zeichen!';
$plug_lang['err_1424'] = $plug_lang['err_1421'] . ' Datei konnte nicht ins gew&uuml;nschte Verzeichnis geschrieben werden!';
$plug_lang['err_1423'] = 'Upload wurde durchgef&uuml;hrt. Datei konnte aber nicht in Datenbank eingetragen werden!';

$plug_lang['spfnc_publish'] = 'Veröffentlichen'; 
$plug_lang['spfnc_facebook_section'] = 'facebook-Veröffentlichung';
$plug_lang['spfnc_facebook_manualsentconfirm'] = 'Erfolgreich veröffentlicht?';
$plug_lang['spfnc_facebook'] = 'Funktionalität aktivieren';
$plug_lang['spfnc_facebook_usn'] = 'Benutzername';
$plug_lang['spfnc_facebook_pwd'] = 'Kennwort';
$plug_lang['spfnc_facebook_app_key'] = 'Anwendungs-API-Schlüssel';
$plug_lang['spfnc_facebook_tpl'] = 'Beschreibungs-Template<small><br/><br/><strong>Bitte beachten Sie folgendes:</strong><br/>Die Maximal zur Verfügung stehende Länge beträgt 1000 Zeichen.<br/>Des weiteren werden Zeilenumbrüche ignoriert.<br/><br/>Es können alle Artikelelemente (siehe Artikelsystem-Ausgabemodul) verwendet werden,<br/>ausgenommen {images} {files} {links} {dates}.</small>';
$plug_lang['spfnc_facebook_tpl_cfg_time'] = '<small>Formatierung Zeit-Elemente</small>';
$plug_lang['spfnc_facebook_tpl_cfg_date'] = '<small>Formatierung Datums-Elemente</small>';
$plug_lang['spfnc_facebook_tpl_cfg_chopmaxlength'] = ' <small>Länge Textkürzung {chop}{/chop}</small>';
$plug_lang['spfnc_facebook_tpl_cfg_chopend'] = '<small>Zeichenkette am Ende der Textkürzung</small>';
$plug_lang['spfnc_facebook_lastsent_data_cf'] = 'Freidef. Feld zur Speicherung der zuletzt veröffentlichten Beschreibung <small><br/>(vom Typ "Mehrz. Textfeld")</small> ';
$plug_lang['spfnc_facebook_lastsent_date_cf'] = 'Freidef. Feld zur Speicherung des letzen Veröffentlichungszeit <small><br/>(vom Typ "Datum+Zeit")</small> ';
$plug_lang['spfnc_facebook_media'] = 'Mediendatei - Freidef. Feld <small>(vom Typ "Bild","Datei" oder "Einz. Textfeld")</small>';
$plug_lang['spfnc_facebook_url'] = 'Link-URL-Template zum Artikel<br/><small>Mögliche Elemente: {baseurl}, {idlang}, {idarticle}, {idcategory}</small>';
$plug_lang['spfnc_facebook_url_name'] = 'Link-URL zum Artikel - Freidef. Feld: Link-Titel <small><br/>(vom Typ "Einz. Textfeld")</small> ';
$plug_lang['spfnc_facebook_url_caption'] = 'Link-URL zum Artikel - Freidef. Feld: Link-Beschreibung <small><br/>(vom Typ "Einz. Textfeld" o. "Mehrz. Textfeld")</small> ' ;
$plug_lang['spfnc_facebook_url_man'] = 'Link-URL zu einer beliebigen Seite - Freidef. Feld: <small>(vom Typ "Link" oder "Text")<br/>Wird eine beliebige Seite gewählt, wird keine Link-URL zum Artikel generiert.<br/>Auch werden die Link-Titel- und ggf. Link-Beschreibungsangaben des Freidef. Feldes <br/>(vom Typ "Link") anstelle der artikel-link-bezogenen Angaben verwendet.</small>';


$plug_lang['spfnc_twitter_section'] = 'twitter-Veröffentlichung';
$plug_lang['spfnc_twitter'] = 'Funktionalität aktivieren';
$plug_lang['spfnc_twitter_usn'] = 'Benutzername';
$plug_lang['spfnc_twitter_pwd'] = 'Kennwort';
$plug_lang['spfnc_twitter_ckey'] = 'Anwendung Benutzer-Schlüssel (Consumer key) <small>(Neue Anwendung <a href="http://twitter.com/apps/new" onclick="void(window.open(this.href, \'\', \'\')); return false;">hier</a> registrieren!)</small>';
$plug_lang['spfnc_twitter_csecret'] = 'Anwendung Benutzer-Geheimnis (Consumer secret)';
$plug_lang['spfnc_twitter_pin_empty'] = 'Anwendung Persönliche Identifikationsnummer (<a href="{url}" onclick="void(window.open(this.href, \'\', \'\')); return false;">Hier</a> anfordern!)';
$plug_lang['spfnc_twitter_pin'] = 'Persönliche Identifikationsnummer';
$plug_lang['spfnc_twitter_tpl'] = 'Veröffentlichungs-Template<small><br/><br/><strong>Bitte beachten Sie folgendes:</strong><br/>Die Maximal zur Verfügung stehende Länge eines "tweets" beträgt 140 Zeichen.<br/>Für einen Link (s.u.) im "tweet" steht das Element {url} zur Verfügung.<br/>Das Element {url} darf sich nicht innerhalb des Textkürzungselements {chop}{/chop} befinden.<br/><br/>Es können alle Artikelelemente (siehe Artikelsystem-Ausgabemodul) verwendet werden,<br/>ausgenommen {images} {files} {links} {dates}.</small>';
$plug_lang['spfnc_twitter_tpl_cfg_time'] = '<small>Formatierung Zeit-Elemente</small>';
$plug_lang['spfnc_twitter_tpl_cfg_date'] = '<small>Formatierung Datums-Elemente</small>';
$plug_lang['spfnc_twitter_tpl_cfg_chopmaxlength'] = '<small>Länge Textkürzungselement {chop}{/chop}</small>';
$plug_lang['spfnc_twitter_tpl_cfg_chopend'] = '<small>Zeichenkette am Ende der Textkürzung</small>';
$plug_lang['spfnc_twitter_url'] = 'Link-URL-Template zum Artikel<br/><small>Mögliche Elemente: {baseurl}, {idlang}, {idarticle}, {idcategory}</small>';
$plug_lang['spfnc_twitter_url_man'] = 'Link-URL zu einer beliebigen Seite - Freidef. Feld: <small><br/>(vom Typ "Link" oder "Text") <small>(vom Typ "Einz. Textfeld")<br/>Wird eine beliebige Seite gewählt, wird keine Link-URL zum Artikel generiert.<br/>Link-Titel- und ggf. Link-Beschreibungsangaben des Freidef. Feldes sind irrelevant und werden nicht verwendet.</small> ';
$plug_lang['spfnc_twitter_lastsent_data_cf'] = 'Freidef. Feld zur Speicherung der zuletzt veröffentlichten Daten  <small><br/>(vom Typ "Mehrz. Textfeld")</small> ';
$plug_lang['spfnc_twitter_lastsent_date_cf'] =  'Freidef. Feld zur Speicherung des letzen Veröffentlichungszeit <small><br/>(vom Typ "Datum+Zeit")</small> ';


?>
