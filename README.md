# Running the project
Use docker and sail to run the project
```sh
./vendor/bin/sail up
```

# Importing my sql data
```sh
./vendor/bin/sail exec -i mysql -usail -ppassword society6_vendor_app < society6_db.sql
```

# API Querying
```
http://localhost/api/vendor/orders?vendor_id=2&format=xml
```
Where vendor_id is the vendor you want to query
format is json or xml response you want to get
