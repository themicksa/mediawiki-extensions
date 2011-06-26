--
-- Table structure for table `user_stats`
--

CREATE TABLE /*_*/user_stats (
  `stats_year_id` int(2) NOT NULL default '0',
  `stats_user_id` int(11) NOT NULL default '0' PRIMARY KEY,
  `stats_user_name` varchar(255) NOT NULL default '',
  `stats_user_image_count` int(11) NOT NULL default '0',
  `stats_comment_count` int(11) NOT NULL default '0',
  `stats_comment_score` int(11) NOT NULL default '0',
  `stats_comment_score_positive_rec` int(11) NOT NULL default '0',
  `stats_comment_score_negative_rec` int(11) NOT NULL default '0',
  `stats_comment_score_positive_given` int(11) NOT NULL default '0',
  `stats_comment_score_negative_given` int(11) NOT NULL default '0',
  `stats_comment_blocked` int(11) NOT NULL default '0',
  `stats_vote_count` int(11) NOT NULL default '0',
  `stats_edit_count` int(11) NOT NULL default '0',
  `stats_opinions_created` int(11) NOT NULL default '0',
  `stats_opinions_published` int(11) NOT NULL default '0',
  `stats_referrals` int(11) NOT NULL default '0',
  `stats_referrals_completed` int(11) NOT NULL default '0',
  `stats_challenges_count` int(11) NOT NULL default '0',
  `stats_challenges_won` int(11) NOT NULL default '0',
  `stats_challenges_rating_positive` int(11) NOT NULL default '0',
  `stats_challenges_rating_negative` int(11) NOT NULL default '0',
  `stats_friends_count` int(11) NOT NULL default '0',
  `stats_foe_count` int(11) NOT NULL default '0',
  `stats_gifts_rec_count` int(11) NOT NULL default '0',
  `stats_gifts_sent_count` int(11) NOT NULL default '0',
  `stats_weekly_winner_count` int(11) NOT NULL default '0',
  `stats_monthly_winner_count` int(11) NOT NULL default '0',
  `stats_total_points` int(20) default '0',
  `stats_overall_rank` int(11) NOT NULL default '0',
  `up_complete` int(5) default NULL,
  `user_board_count` int(5) default '0',
  `user_board_sent` int(5) default '0',
  `user_board_count_priv` int(5) default '0',
  `stats_picturegame_votes` int(5) default '0',
  `stats_picturegame_created` int(5) default '0',
  `user_status_count` int(5) default '0',
  `stats_poll_votes` int(5) default '0',
  `user_status_agree` int(11) default '0',
  `stats_quiz_questions_answered` int(11) default '0',
  `stats_quiz_questions_correct` int(11) default '0',
  `stats_quiz_points` int(11) default '0',
  `stats_quiz_questions_created` int(11) default '0',
  `stats_quiz_questions_correct_percent` float default '0',
  `stats_links_submitted` int(11) NOT NULL default '0',
  `stats_links_approved` int(11) NOT NULL default '0'
)  DEFAULT CHARSET=utf8;
