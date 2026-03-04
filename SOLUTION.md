# Solution

## Phase 1: Entity Relationship Diagram

### Entity Relationship Diagram

![Assessment ERD](public/erd.png)

### Diagram Description

Assessments have a 1:N relationship with Assessment Sessions.
Assessments have an N:M relationship with Assessment Questions (via assessments_questions).
Assessment Sessions have a 1:N relationship with Assessment Instances.
Assessment Instances have an N:M relationship with Assessment Answer Options (via assessment_answers).
Assessment Questions have a 1:N relationship with Assessment Answer Options.
