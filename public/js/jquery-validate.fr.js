/**
 * Created by STAGIAIRE on 21/12/2016.
 */
$.extend($.validator.messages, {
    required           : "Ce champ est requis.",
    email              : "Veuillez saisir une adresse mail valide.",
    url                : "Veuillez saisir une URL valide.",
    creditcard         : "Veuillez saisir un numéro de carte de crédit valide.",
    date               : "Veuillez saisir une date valide.",
    datetime           : "Veuillez saisir une date/heure valide.(aaaa-mm-jjThh:mm:ssZ)",
    'datetime-local'   : "Veuillez saisir une date/heure locale valide.(aaaa-mm-jjThh:mm:ss)",
    time               : "Veuillez saisir une heure valide.",
    alphabetic         : "Veuillez ne saisir que des lettres.",
    alphanumeric       : "Veuillez ne saisir que des lettres, souligné et chiffres.",
    color              : "Veuillez saisir une couleur valide. (nommée, hexadecimale ou rvb)",
    month              : "Veuillez saisir une année et un mois. (ex.: 1974-03)",
    week               : "Veuillez saisir une année et une semaine. (ex.: 1974-W43)",
    number             : "Veuillez saisir un nombre.(ex.: 12,-12.5,-1.3e-2)",
    integer            : "Veuillez saisir un nombre sans decimales.",
    zipcode            : "Veuillez saisir un code postal valide.",
    minlength          : "Veuillez saisir au moins {0} caractères.",
    maxlength          : "Veuillez ne pas saisir plus de {0} caractères.",
    min                : "Veuillez saisir une valeur supérieure ou égale à {0}.",
    max                : "Veuillez saisir une valeur inférieure ou égale à {0}.",
    mustmatch          : "Veuillez resaisir la même valeur.",
    captcha            : "Votre réponse ne correspond pas au texte de l'image. Réesayez.",
    personnummer       : "Veuillez saisir un personnummer valide. (aaaammjj-aaaa)",
    organisationsnummer: "Veuillez saisir un organisationsnummer valide. (xxyyzz-aaaa)",
    ipv4               : "Veuillez saisir une adresse IP valide (version 4).",
    ipv6               : "Veuillez saisir une adresse IP valide (version 6).",
    tel                : "Veuillez saisir un numéro de téléphone valide.",
    remote             : "Veuillez vérifier ce champ."
});