
# Sports Arena Time Slot Management

This project is designed to manage time slots and bookings for a sports arena using  **Domain-Driven Design (DDD)**  principles. The system is structured into multiple domains, utilizes design patterns, and leverages modern PHP packages for cleaner and maintainable code.

----------

## **Domains**

The system is divided into the following domains:

1.  **Arena Domain**

    -   Handles core arena-related logic, such as time slot creation and management.

    -   Includes strategies for defining time slot creation processes.

2.  **Booking Domain**

    -   Manages booking-related operations.

    -   Ensures bookings are validated against available time slots.

3.  **Shared Domain**

    -   Contains shared logic and utilities used across other domains.

    -   Currently includes the  **User Domain**.


----------

## **Design Patterns**

### **Strategy Pattern**

-   Used for  **time slot creation**  to allow flexibility in defining how time slots are generated.

-   Enables easy updates or extensions to the time slot creation process in the future.


### **Custom Query Builder**

-   Custom query builders are implemented for both  **Timeslot**  and  **Booking**  models.

-   Preferring query builders over the repository pattern for simplicity and direct control over queries.


----------

## **Packages Used**

### **Spatie Data Package**

-   Used for  **DTO (Data Transfer Object)**  classes to ensure cleaner and fewer classes.

-   Simplifies data handling and validation across the application.


### **Actions**

-   Actions are used to encapsulate business logic into reusable classes.

-   Promotes single responsibility and improves code readability.