Hallo

In MySQL MUSS **max_allowed_packet** unbedingt erhöht werden damit die Contest Bilder richtig gespeichert werden können.
Gehe dazu unter `mysql/bin/my.ini`. Dort einfach den Wert von `max_allowed_packet` auf `10M` erhöhen.