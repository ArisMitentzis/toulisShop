#Touli Shop

It is hosted at Heroku and its DB at remotemysql.com.

http://toulisshop.herokuapp.com (prefer Chrome)

The current CV project implements an imaginary pet e-shop. It was created in the context 
of a university assignment under a short notice and aimed at familiarizing myself with the
most common web technologies and not necessarily creating the most efficient design. 
Only the dog category of products is fully realized and text is written in Greek because of 
the assignment instructions but plan (maybe) to translate it in English sometime in the future.

A signed-in user may have a look at the products and add anything to the cart. He could also 
edit his cart and finalize his order. Of course, he can view all his orders. An admin user has 
the choice of adding any new product. He can view, edit or delete the existing products. He 
could also view all the orders and edit their state. Finally, he may view all the user accounts 
and some statistics. 

Technical description:
Back-end:
    - MySql database   - Functional PHP
Front-end:
   - HTML,CSS,Bootstrap   - Javascript,JQuery,Ajax
      
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Το συγκεκριμένο CV project υλοποιεί ένα ηλεκτρονικό κατάστημα Pet Shop. Δημιουργήθηκε ως εργασία, 
στα πλαίσια της ενότητας ΠΛΗ23. Στόχος ήταν η εξοικείωση με βασικές web τεχνολογίες και όχι η 
βέλτιστη σχεδίαση, καθώς υπήρχε στενό και αυστηρό deadline. Υλοποιημένη είναι μόνο η κατηγορία 
των σκύλων. Οι υπόλοιπες είναι εικονικές. Επιπλέον, οι σελίδες είναι γραμμένες στα ελληνικά 
διότι έτσι ζητήθηκε αλλά πρόκειται να μεταφραστεί και στα αγγλικά.

Βασική λειτουργική περιγραφή:
Υπαρχουν 3 τυποι user:
-Guest,δηλαδη not logged in.  -Simple user,δηλαδη logged in but not admin.  - Admin,δηλαδη logged in  and admin.
   
Κάποιος guest μπορεί:
- να δει τα προϊόντα χωρίς να τα προσθέσει στο καλάθι (index.php) και (page2.php).
- να συνδεθει αν διαθέτει λογαριασμό (sign_in.php) ή να δημιουργήσει λογαριασμό αν δεν εχει (sign_up.php).

Κάποιος simple user μπορεί:
- να δει τα προϊόντα και να προσθέσει στο καλάθι οτι επιθυμει να αγορασει (index.php) και (page2.php).
- να δει και να επεξεργαστεί το καλάθι του και να οριστικοποιήσει την παραγγελία του. (page3.php).
- να τροποποιησει ή να διαγράψει τον λογαριασμό του.(account.php).
- να δει το σύνολο των παραγγελιών του. (myOrders.php).

Κάποιος admin μπορεί:
- να προσθέσει προϊόν (add_product.php), καθώς και να δει πίνακα όλων των προϊόντων με δυνατότητα επεξεργασίας
  και διαγραφής του καθενός (list_delete_product.php).
- να δει το σύνολο όλων των παραγγελιών και για καθεμία, να αλλάξει την κατασταση της, καθώς και να δει την 
  ανάλυση της (allOrders.php).
- να αναζητήσει παραγγελίες φιλτράροντας για κάποιο χρονικό διάστημα (xml_config.php).Η συγκεκριμένη λειτουργία
  ζητήθηκε να γίνει με παραγωγή xml και η παρουσίαση με χρήση αρχείου xsl. Οπότε, όταν ο χρήστης εκτελεί αναζήτηση
  για συγκεκριμένο χρονικό διαστημά παράγεται ένα αρχείο xml με τα σχετικά δεδομένα,το οποίο αποθηκεύεται στον 
  φάκελο με όνομα xml. Γίνεται έλεγχος αν το xml είναι valid με κριτήριο το αρχείο 'xml\aboutOrders.dtd'. 
  Η παρουσίαση των αποτελεσμάτων γίνεται στη σελίδα xml_view.php με χρηση του αρχείου 'xml\allOrdersAndTop5SalesProducts.xsl'.
- να δει το σύνολο των λογαριασμών των χρηστών. (allUsers.php).
- να δει μια στατιστική επισκόπηση (τζίρος, δημοφιλέστερα προϊόντα,καλύτεροι πελάτες). (statistics.php).

Λίγες λεπτές παρατηρήσεις:
- Τα τετράγωνα με τα προϊόντα και το pagination στις σελίδες (index.php) και (page2.php) εχουν δημιουργηθεί from 
  scratch αντί να χρησιμοποιηθει π.χ το jquery owlCarousel. Αυτή η επιλογή έγινε για εκπαιδευτικούς λόγους, αν και αισθητικά -
  όπως είναι λογικό - υπολείπεται αρκετα. Αντίθετα, όπου υπάρχουν πίνακες έχει χρησιμοποιηθεί το mainstream plug-in Datatables,
  όπως π.χ στη σελίδα (allOrders.php).
- Στις σελίδες (index.php) και (page2.php), όταν ο χρήστης ανεβάζει την ποσότητα κάποιου προϊόντος, η σελίδα του επιτρέπει 
  να φθάσει μέχρι το στοκ που υπάρχει τη στιγμή που φορτώθηκε η σελίδα.
- Σε όλες τις φόρμες (π.χ στο sign_up.php) υπάρχει έλεγχος validation με σαφή μηνύματα στα πεδία όπου υπάρχει invalid input.
- Στη σελίδα (allOrders.php), όταν ο χρήστης αλλάξει την κατάσταση σε 'Απεστάλη', ελέχγεται αν σε κάποιο από τα προϊόντα της 
  παραγγελίας δεν επαρκεί το στοκ. Εφόσον υπάρχει έλλειψη σε τουλάχιστον ένα προϊόν, το κουμπί της ανάλυσης κοκκινίζει και 
  εμφανίζει ένα καμπανακι. Επιπλέον, όταν ο χρήστης δει την ανάλυση, το πεδίο που απεικονίζει το σχετικό στοκ θα είναι κοκκινισμένο.