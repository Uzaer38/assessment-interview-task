# Solution - Uzaer Shahid

## Phase 1: Entity Relationship Diagram

### Entity Relationship Diagram

![Assessment ERD](backend/public/erd.png)

### Diagram Description

Assessments have a 1:N relationship with Assessment Sessions.

Assessments have an N:M relationship with Assessment Questions (via assessments_questions).

Assessment Sessions have a 1:N relationship with Assessment Instances.

Assessment Instances have an N:M relationship with Assessment Answer Options (via assessment_answers).

Assessment Questions have a 1:N relationship with Assessment Answer Options.

## Phase 2: getProgressAndScore function

getProgressAndScore() calculates assessment progress and scoring for a single AssessmentInstance.

It returns:

- total number of questions
- number of answered questions
- completion percentage
- total score and maximum score
- normalized percentage score
- per element scoring
- structured questions + answer data

It builds a complete progress report for an assessment attempt.

### Scoring algorithm

Only option based answers are scored. 

The function picks the most recent answer in the instance for each question. That option value is added to totalScore.

For each question, it calculates the question max as the highest option value for that question, usually 5. The max value is added to maxScore.

Each answered question will give at least 1 point since Likert is 1 to 5.

So, in order to generate a percentage, the function normalises by subtracting 1 for each answered question.

The normalised percentage is (normalisedTotalScore/normalisedMaxScore)*100

### Error handling

There are two main categories of error handling I've added to this function:

### 1. Empty/Null Fetch Handling

Currently we are not handling the case that session or assessment are null. If either session or assessment is null, PHP will throw a fatal error.

So I added these safeguards to handle that case smoothly.

```
$session = $instance->getSession();
if (!$session) {
    throw new \RuntimeException('AssessmentInstance has no session.');
}

$assessment = $session->getAssessment();
if (!$assessment) {
    throw new \RuntimeException('AssessmentSession has no assessment.');
}
```

### 2. Exclude Reflection Questions from Scoring

Right now, the function calculates the maxScore even for reflective questions, which is unneeded even if it is 0 for those questions.

So I reordered the skip to be before anything was calculated if isReflectiveQuestion is true.

```
if ($question->getIsReflection()) {
    $elementQuestionAnswersData[] = $questionData;
    $questionAnswersData[] = $questionData;
    continue;
}
```

### 3. Ensure questions belong to the current assessment

Currently there is no explicit check to make sure the answer options referenced by an answer are part of the one current assessment's questions.

I added a change so that before scoring a question, this is checked, and it is ignored if so. This can also be changed to be a RuntimeException if it is desired that invalid data is surfaced.

```
if ($answerOption->getAssessmentQuestion()->getId() !== $questionId) {
    continue;
}
```

## Task Completed
Full-Stack

## Time Spent
[Approximate hours]

## Approach
[Explain your overall approach and strategy]

## Implementation Details
[Describe what you built and key decisions you made]

## Tools & Libraries Used
- [List any libraries/packages you added]
- AI tools used: [ChatGPT, Claude, Copilot, none, etc.]
  - [Briefly explain how you used them if applicable]

## Testing
[Explain how to test your implementation]
[Include curl commands, URLs, or test scenarios]

## Challenges & Solutions
[Describe any difficulties and how you overcame them]

## Trade-offs & Future Improvements
[What would you do differently with more time?]
