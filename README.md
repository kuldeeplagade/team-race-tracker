# 🏁 Team Race Tracking System

The **Team Race Tracking System** is a Laravel-based web app that helps manage team-based races or treks.  
Admins can create teams, members, races, and checkpoints — and users can record when members reach each checkpoint.  
It also generates race and team performance reports with total time tracking.

---

## ⚙️ Setup Instructions

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/kuldeeplagade/team-race-tracker.git

2️⃣ Install Dependencies
composer install

3️⃣ Run Migrations & Seeders
php artisan migrate --seed

4️⃣ Serve the Application
php artisan serve
Open http://localhost:8000 in your browser.

🧱 Schema & Relationship Explanations
 | Table              | Description                                    |
| ------------------ | ---------------------------------------------- |
| `teams`            | Stores team details                            |
| `team_members`     | Members belonging to each team                 |
| `races`            | Race or trek master table                      |
| `race_checkpoints` | Checkpoints of each race with sequential order |
| `race_logs`        | When a member reaches a checkpoint             |


Relationships :

A team has many members.
A race has many checkpoints, ordered by order_no.
A member logs progress in race_logs.
Each log belongs to one race, one member, and one checkpoint.
Duplicate or out-of-order checkpoints are not allowed for the same member.

⏱️ Time Calculation Logic

Each member’s race completion time is calculated as:
Get the time reached at the first and last checkpoints.
Subtract start time from end time → total duration.
Convert it into days, hours, minutes, seconds format.
Sort all members by shortest total time (fastest first).
For team ranking — take the average of members’ total times in the same team.


👨‍💻 Developed by

[Kuldeep Lagade]
Full Stack Developer (Laravel + MySQL + Bootstrap)
🔗 LinkedIn: https://linkedin.com/in/kuldeep-lagade
💻 GitHub: https://github.com/kuldeeplagade/