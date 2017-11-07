# Activity Feed Notification System

Technical implementation of Activity feed and facebook like notifications for Codeigniter

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

* Git clone the project
* Import database from db folder `activity_feed_notification_system.sql`
* Add system activities along with templates for each

## Usage

```
$this->load->model('Activity_model');
$this->Activity_model->add_user_activity(34, 'INVITE_USER', 45, array('user-email' => 'user1@example.com'));
```

## Built With

* [Codeigniter 3.1.6](https://codeigniter.com/docs) - The web framework used
* [Bootstrap 4](http://getbootstrap.com/docs/4.0/getting-started/download/) - Front-end CSS library
* [mCustomScrollbar](http://manos.malihu.gr/jquery-custom-content-scroller/) - Custom scrollbar for notification box

## Authors

* **Yash Desai** - [yashdesai87](https://github.com/yashdesai87)