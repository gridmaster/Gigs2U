UPDATE posts AS p
LEFT JOIN users AS u ON u.username = p.added_by
SET p.added_by_ID = u.memberID


UPDATE posts AS p
LEFT JOIN users AS u ON u.username = p.user_to
SET p.user_to_ID = u.memberID