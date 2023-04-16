package main

import (
	"database/sql"
	"encoding/json"
	"fmt"
	"log"
	"net/http"

	_ "github.com/lib/pq"
)

func main() {
	// http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
	// 	fmt.Fprintf(w, "Hello, you,ve requested %s\n", r.URL.Path)
	// })

	http.HandleFunc("/things", func(w http.ResponseWriter, r *http.Request) {
		switch r.Method {
		case "GET":
			handleGetThings(w, r)
		case "POST":
			handlePostThings(w, r)
		default:
			fmt.Fprintf(w, "Sorry, this HTTP method is not supported.")
		}
	})

	log.Fatal(http.ListenAndServe(":8001", nil))
}

func handleGetThings(w http.ResponseWriter, r *http.Request) {

	connStr := "postgres://myuser:mypassword@localhost:5432/mydb?sslmode=disable"
	db, err := sql.Open("postgres", connStr)
	if err != nil {
		log.Fatal(err)
	}

	rows, err := db.Query("select * from thing")

	if err != nil {
		log.Fatal(err)
	}

	var arr []Thing
	for rows.Next() {
		var thing Thing
		if err := rows.Scan(&thing.Id, &thing.Name, &thing.Count); err != nil {
			log.Fatal(err)
		}
		arr = append(arr, thing)
	}

	json.NewEncoder(w).Encode(arr)
}

func handlePostThings(w http.ResponseWriter, r *http.Request) {

}

type Thing struct {
	Id    int64  `json:"id"`
	Name  string `json:"name"`
	Count int64  `json:"count"`
}
