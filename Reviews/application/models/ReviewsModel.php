<?php

class ReviewsModel extends Model
{
    public function getReviews($where = null)
    {
        $query = 'reviews.id = reviews_status.review_id';

        if ($where)
            $where = "WHERE $where AND $query";
        else
            $where = 'WHERE ' . $query;

        $order = 'date DESC';

        if (isset($_GET['order'])) {
            if ($_GET['order'] == 'name')
                $order = 'name';
            elseif ($_GET['order'] == 'email')
                $order = 'email';
        }

        $query = "SELECT * FROM reviews, reviews_status $where ORDER BY $order";

        $result = $this->query($query);

        if(method_exists($result, 'fetch_all'))
            $result = $result->fetch_all(MYSQLI_ASSOC);
        else
            $result = $this->mysqliFetchAll($result);
        
        return $result;
    }

    public function sendReview(array $review)
    {
        $set = $this->getFieldsForSet($review);

        //на случай, если хостинг не поддерживает CURRENT_TIMESTAMP
        $set .= ', date = NOW()';

        $query = "INSERT INTO reviews SET $set";

        $result_id = $this->insert($query);

        $query = "INSERT INTO reviews_status SET review_id = $result_id";

        $this->query($query);

        return $result_id;
    }

    public function updateReview(array $review, $id)
    {
        $set = $this->getFieldsForSet($review);

        $query = "UPDATE reviews SET $set WHERE id = $id";

        $this->query($query);

        $query = "UPDATE reviews_status SET changed = 1 WHERE review_id = $id";

        $this->query($query);

        return true;
    }

    protected function getFieldsForSet(array $review)
    {
        $set = '';

        foreach ($review as $row => $value)
            $set .= "$row = '$value', ";

        $set = trim(trim($set), ',');

        return $set;
    }
}