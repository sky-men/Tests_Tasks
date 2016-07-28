<?php


class ReviewsStatusModel extends Model
{
    public function setAccepted($review_id)
    {
        $query = "UPDATE reviews_status SET on_moderation = 0, rejected = 0, accepted = 1 WHERE review_id = $review_id";

        $this->query($query);

        return true;
    }

    public function setRejected($review_id)
    {
        $query = "UPDATE reviews_status SET on_moderation = 0,  accepted = 0, rejected = 1 WHERE review_id = $review_id";

        $this->query($query);

        return true;
    }

    public function setOnModeration($review_id)
    {
        $query = "UPDATE reviews_status SET on_moderation = 1,  accepted = 0, rejected = 0 WHERE review_id = $review_id";

        $this->query($query);

        return true;
    }
}