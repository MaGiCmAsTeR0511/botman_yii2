<?php

/* @var $this yii\web\View */

$this->title = 'Chatbot Kategorisierung von Tickets';
?>
<div class="col-auto">
<h2> Willkommen beim Prototypen des Chatbots für die Kategorisierung von Tickets</h2>
<p> Dieser Chatbot dient dazu Tickets die normalerweise über Mail oder über das Telefon von den Mitarbeitern aufgenommen
    werden. Diese werden dann in eine Tickestsystem übernommen und landen dort meist in der Eingangsqueue im Ticketsystem.
    Dort wird das Ticket dann meistens über einen Mitarbeiter in die richtige Kategorie bzw. Queue verschoben, wo es dann
    von dem entsprechenden Mitarbiter übernommen und abgearbeitet wird.</p>
<p> Um dieses Verhalten zu simulieren wurden bereits folgenden Abteilungen und Teams im Hintergrund definiert:</p>
    <ul>
        <li> IT-Abteilung
            <ul>
                <li> Web-Team (Zuständig alles Rund ums Web, Browser, Homepages, etc ....)</li>
                <li> Client-Team (Zuständig für alles Rund um den Computer, Bildschirm, Maus, Tastatur, Switches, etc.....) </li>
            </ul>
        </li>
        <li> Finanzabteilung
            <ul>
                <li> Salary-Team (Zuständig alles Rund ums Gehalt, Steuer, Nachzahlungen, etc ....)</li>
            </ul>
        </li>
        <li> FacilityManagement
            <ul>
                <li> Facility-Team (Zuständig alles Rund ums Gebäude, Fenster, Aufzüge, etc ....)</li>
                <li> Electricity-Team (Zuständig für alles Rund um Strom, Licht, Elektroautos, etc..... </li>
            </ul>
        </li>
    </ul>
    <h3>Ablauf Chatbot Conversation</h3>
    <p> Der Ablauf gliedert sich in folgende Punkte:</p>
    <ol>
        <li> Der Chatbot hört auf das schlagwort <b>Problem</b>. Damit wird alles in Gang gesetzt.</li>
        <li> Der Chatbot fragt ob man das Problem mit ihm teilen möchte? hier gibt es nur die Möglichkeiten mit <b>Ja</b> und <b>Nein</b> zu antworten! </li>
        <li> Der Chatbot möchte nun das Problem so genau und ausführlich wie möglich hören. </li>
        <li> Nach Eingabe des Problems analysiert der Chatbot den eingegebenen Text.</li>
        <li> Jetzt antwortet der Chatbot mit einem möglichen Vorschlag in welche Abteilung ung zu welchem Team er das Ticket zuordnen würde.</li>
        <li> Sollte diese Antwort zutreffen dann einfach mit Ja antworten</li>
        <li> Sollte das nicht zutreffen dann mit Nein
            <ul>
                <li>Nun wird man gefragt welcher Abteilung und Team man es zurodnen will, dieses eingeben als ABTEILUNG,Team</li>
            </ul>
        </li>
        <li> Somit ist der Vorgang abgeschlossen und vielen Dank fürs mitmachen </li>
    </ol>
    <b>Zur Auswertung werden nur jene Daten gespeichert die auch wirklich notwendig sind!!! Diese Daten sind das Problem
        und sollte es nicht automatisch zugeordnet werden können die Angaben zur Zuordnung des Users selbst</b>
    <h3> Um den Chatbot nun zu testen bitte rechts unten auf den runden Button mit dem Briefumschlag drücken </h3>
</div>
<script>
var botmanWidget = {
    title: "Chatbot Kategorisierung von Tickets",
    introMessage: "Willkommen beim Ticket-Chatbot!",
    aboutText: "Powered By Kurt Hohenauer",
    frameEndpoint: '/site/chatframe',
    chatServer: '/chatbot/hearbot'
};
</script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

<head>
    <title>BotMan Widget</title>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">-->
</head>

