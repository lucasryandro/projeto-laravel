$(".openExercise").on("click", function(){
    const $this = $(this);
    const $exercise = $this.closest(".exercise-unique");
    const $exerciseSets = $exercise.find(".setsExercise");

    if(!$exerciseSets.hasClass("active")) {
        $(".setsExercise").slideUp();
        $(".setsExercise").removeClass("active");
    };

    if($exerciseSets.is(":visible")) return  $exerciseSets.slideUp();

    $exerciseSets.slideDown();
    $exerciseSets.addClass("active");
});
