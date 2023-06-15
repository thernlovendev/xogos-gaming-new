const mysql = require("mysql");
const axios = require("axios");

// Create a connection pool
const pool = mysql.createPool({
  host: "0.0.0.0",
  user: "thernloven",
  password: "root",
  database: "xogos",
});

async function main() {
  // Example data from API
  const apiUrl = "https://lightninground.rocks/api";
  let totalCollectedCoins = await axios.get(apiUrl + "/totalCollectedCoins");

  // Loop through the API data and insert/update the values in the database
  totalCollectedCoins.data.data.forEach((data) => {
    if (data.username != null) {
      // Check if the username already exists in the database
      const query = `SELECT * FROM users WHERE username = '${data.username}'`;
      pool.query(query, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          // If the username exists, update the value of coins
          const updateQuery = `UPDATE users SET total_coins = ${data.coins} WHERE username = '${data.username}'`;
          pool.query(updateQuery, (error, results) => {
            if (error) throw error;
            console.log(`Updated ${data.username} with ${data.coins} coins`);
          });
        } else {
          // If the username does not exist, insert a new row with the username and coins
          const insertQuery = `INSERT INTO users (username, total_coins) VALUES ('${data.username}', ${data.coins})`;
          pool.query(insertQuery, (error, results) => {
            if (error) throw error;
            console.log(`Inserted ${data.username} with ${data.coins} coins`);
          });
        }
      });
    }
  });

  let timeGamgePlayed = await axios.get(apiUrl + "/timeGamgePlayed");
  timeGamgePlayed.data.data.forEach((data) => {
    // Check if the username already exists in the database
    if (data.username != null) {
      const query = `SELECT * FROM users WHERE username = '${data.username}'`;
      pool.query(query, (error, results) => {
        if (error) throw error;
        if (results.length > 0) {
          // If the username exists, update the value of coins
          const updateQuery = `UPDATE users SET total_time = ? WHERE username = ?`;
          console.log(data.game_time, data.username);
          pool.query(
            updateQuery,
            [data.game_time, data.username],
            (error, results) => {
              if (error) throw error;
              console.log(
                `Updated ${data.username} with ${data.game_time} coins`
              );
            }
          );
        } else {
          // If the username does not exist, insert a new row with the username and coins
          const insertQuery = `INSERT INTO users (username, total_time) VALUES ('${data.username}', ${data.game_time})`;
          pool.query(insertQuery, (error, results) => {
            if (error) throw error;
            console.log(
              `Inserted ${data.username} with ${data.game_time} coins`
            );
          });
        }
      });
    }
  });
}

setInterval(main, 5000);
