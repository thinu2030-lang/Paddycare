# 🌾 PaddyCare — Paddy Disease Identification Web Application

PaddyCare is a smart agricultural web application developed to help paddy farmers identify rice leaf diseases and access useful cultivation support.

The system uses **Machine Learning-based image classification** to analyze uploaded paddy leaf images and provide a predicted disease with a confidence score. It also provides treatment recommendations, seed variety information, crop tracking, and communication with field officers.

## 🚀 Main Features

* 🌿 **Paddy Disease Detection** — Upload a paddy leaf image and identify the predicted disease.
* 🤖 **Machine Learning** — Uses a trained deep learning model for disease classification.
* 💊 **Treatment Recommendations** — Provides chemical, organic, and integrated pest management recommendations.
* 🌱 **Seed Guide** — Provides paddy variety information based on district and cultivation season.
* 📅 **Field Officer Appointments** — Farmers can book appointments with field officers.
* 👨‍🌾 **Farmer Dashboard** — Manage diagnoses, appointments, crop activities, and notifications.
* 👨‍💼 **Field Officer Dashboard** — Review farmer diagnoses, provide advice, manage appointments, and publish articles.
* 📝 **Agricultural Articles** — Farmers can access useful paddy cultivation information.
* 🌾 **Harvest Tracker** — Track important cultivation activities from sowing to harvesting.
* 📧 **Notifications & Emails** — Send notifications and district-based farmer communications.
* 🔐 **Role-Based Access Control** — Separate access for Farmers, Field Officers, and Administrators.
* 📊 **Admin Management & Reports** — Manage users, diseases, articles, and system reports.

## 🛠️ Technologies Used

### Web Application

* PHP 8.3
* Laravel 11
* MySQL 8.0
* HTML5
* CSS3
* JavaScript
* Bootstrap
* Blade Templates

### Machine Learning

* Python
* Flask
* TensorFlow / Keras
* MobileNetV2
* Transfer Learning
* Paddy Disease Image Dataset

### Development Tools

* Laragon
* Visual Studio Code
* Git & GitHub
* Google Colab

## 🤖 Machine Learning

PaddyCare includes a Machine Learning component for paddy leaf disease identification.

The workflow is:

**Paddy Leaf Image → Image Processing → Trained ML Model → Disease Prediction → Confidence Score → Treatment Recommendation**

The model was developed using **MobileNetV2 transfer learning** with a paddy disease image dataset.

## 👥 User Roles

### 👨‍🌾 Farmer

* Register and log in
* Upload paddy leaf images
* View disease predictions
* View treatment recommendations
* View seed varieties
* Track cultivation activities
* Book field officer appointments
* Read agricultural articles

### 👨‍💼 Field Officer

* Manage appointments
* Review farmer diagnoses
* Provide expert advice
* Manage agricultural articles
* Send notifications to farmers

### 👨‍💻 Administrator

* Manage users
* Manage diseases
* Manage articles
* Manage field officers
* View system reports

## 🏗️ System Architecture

PaddyCare uses a web application architecture where the Laravel application communicates with a separate Python Flask Machine Learning service.

```text
Farmer
   ↓
Laravel Web Application
   ↓
Image Upload
   ↓
Python Flask ML Service
   ↓
Trained TensorFlow/Keras Model
   ↓
Disease Prediction + Confidence
   ↓
Laravel Application
   ↓
Treatment Recommendation
```

## 📂 Project Structure

```text
PaddyCare/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── composer.json
├── package.json
└── README.md
```

## 🎯 Project Objective

The main objective of PaddyCare is to provide farmers with an accessible digital platform for paddy disease identification and cultivation support, while improving access to agricultural information and field officer assistance.

## 📌 Project Type

**Academic / Final Year Project**

Developed as part of the **Higher National Diploma in Information Technology (HND IT)**.

## 👩‍💻 Developer

**B.M.T.Y. Chandrarathna**

GitHub: [@thinu2030-lang](https://github.com/thinu2030-lang)
