<?php
class AppointmentCalendar {
    private $db;
    private $max_daily_appointments = 8;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function generateCalendarMonth($month, $year) {
        $month = (int)$month;
        $year = (int)$year;

        if ($month < 1 || $month > 12) {
            throw new Exception('Invalid month');
        }

        $first_day = mktime(0,0,0,$month,1,$year);
        $days_in_month = date('t', $first_day);
        $days_of_week = date('w', $first_day);

        $calendar = '<div class="calendar-month">';
        $calendar .= '<div class="calendar-header">';
        $calendar .= date('F Y', $first_day);
        $calendar .= '</div>';

        $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        foreach($days  as $day) {
            $calendar .= "<div class='calendar-day-header'>$day</div>";
        }

        $query = "SELECT date, is_available, current_bookings FROM calendar_availability WHERE MONTH(date) = ? AND YEAR(date) = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$month, $year]);
        $availability = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        for ($i = 0; $i < $days_of_week; $i++) {
            $calendar .= "<div class='calendar-day empty'></div>";
        }

        $current_day = 1;
        while($current_day <= $days_in_month) {
            $date = sprintf("%04d-$02d-%02d", $year, $month, $current_day);
            $available = $availability[$date]['is_available'] ?? true;
            $bookings = $availability[$date]['current_bookings'] ?? 0;

            $class = 'calendar-day';
            if (!$available) {
                $class .= ' unavailable';
            } elseif ($bookings >= $this->max_daily_appointments) {
                $class .= ' full';
            }

            $calendar .= "<div class='$class' data-date='$date'>";
            $calendar .= "<div class='day-number'>$current_day</div>";
            if ($available && $bookings < $this->max_daily_appointments) {
                $slots = $this->max_daily_appointments - $bookings;
                $calendar .= "<div class='slots-left'>$slots slots left</div>";
            }
            $calendar .= "</div>";

            $current_day++;
        }

        $calendar .= '</div>';
        return $calendar;
    }

    public function checkAvailability($date) {
        $query = "SELECT is_available, current_bookings, max_bookings FROM calendar_availability WHERE date = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}