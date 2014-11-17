<?php
/**
 * Created by PhpStorm.
 * User: svenanders
 * Date: 27.10.14
 * Time: 08.29
 */
setlocale(LC_TIME, array('nb_NO.UTF-8', 'nb_NO@euro', 'nb_NO', 'norwegian'));
setlocale(LC_ALL, 'nb_NO');

$_registerproduct="Registrer ditt produkt";
$_firstname="Fornavn";
$_lastname="Etternavn";
$_address="Adresse";
$_nummer="Gatenr";
$_city="Sted";
$_state="Fylke";
$_country="Land";
$_zipcode="Postnummer";
$_phone="Telefon";
$_email="Epostadresse";
$_purchasedate="Kjøpsdato";
$_purchaseplace="Kjøpssted";
$_other="Annet";
$_serialnumber="Serienummer";
$_sendmetips="Send meg oppskrifter, tips og nyheter!";
$_canunsub="(du kan si opp abonnementet når som helst)";
$_register="Registrer Mitt Produkt";
$_states = <<<STATES
<optgroup label="Velg Fylke">
        <option value="AKR">AKERSHUS</option>
        <option value="OSL">OSLO</option>
        <option value="OPL">OPPLAND</option>
        <option value="ØFO">ØSTFOLD</option>
        <option value="BUS">BUSKERUD</option>
        <option value="VFO">VESTFOLD</option>
        <option value="TEL">TELEMARK</option>
        <option value="AGD">AGDER</option>
        <option value="A-AGD">AUST-AGDER</option>
        <option value="V-AGD">VEST-AGDER</option>
        <option value="ROG">ROGALAND</option>
        <option value="HRD">HORDALAND</option>
        <option value="SFJ">SOGN OG FJORDANE</option>
        <option value="MRO">MØRE OG ROMSDAL</option>
        <option value="TRØ">TRØNDELAG</option>
        <option value="STR">SØR-TRØNDELAG</option>
        <option value="NTR">NORD-TRØNDELAG</option>
        <option value="NRL">NORDLAND</option>
        <option value="TRO">TROMS</option>
        <option value="FNM">FINNMARK</option>
</optgroup>
STATES;
$_countries = <<<COUNTRY
<optgroup label="Velg Land">
    <option value="NOR" selected="selected">Norge</option>
    <option value="SWE">Sverige</option>
    <option value="DEN">Danmark</option>
</optgroup>
COUNTRY;
$month=date("m");
$_months = <<<MONTHS
<optgroup label="Velg Måned ">
    <option {if($month===1) echo 'selected="selected"';} value="01">Januar</option>
    <option value="02">Februar</option>
    <option value="03">Mars</option>
    <option value="04">April</option>
    <option value="05">Mai</option>
    <option value="06">Juni</option>
    <option value="07">Juli</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option {if($month===10) echo 'selected="selected"';} value="10">Oktober</option>
    <option value="11">November</option>
    <option value="12">Desember</option>
</optgroup>
MONTHS;
$_countries = <<<COUNTRY
<optgroup label="Velg Land">
    <option value="NOR" selected="selected">Norge</option>
    <option value="SWE">Sverige</option>
    <option value="DEN">Danmark</option>
</optgroup>
COUNTRY;
