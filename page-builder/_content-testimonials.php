 <?php echo do_shortcode('[trustindex no-registration=google]'); ?>

 <!-- <?php
        $testimonials = [];
        if (function_exists('have_rows') && have_rows('testimonials')) {
            while (have_rows('testimonials')) {
                the_row();
                $testimonials[] = [
                    'image'   => get_sub_field('author_image'),
                    'name'    => get_sub_field('author_name'),
                    'title'   => get_sub_field('author_title'),
                    'content' => get_sub_field('testimonial_content'),
                ];
            }
        }

        $testimonials_looped = [];
        if (!empty($testimonials)) {
            $testimonials_looped = array_merge($testimonials, $testimonials, $testimonials);
        }
        ?> -->
 <!--
<div class="testimonial-slider-wrapper relative !md:txs-h-390 txs-h-288">
	<div class="flex absolute bottom-0 !md:txs-right-100 txs-right-170 justify-between !md:txs-w-60 txs-w-52 items-center" style="z-index:1000">
		<button id="testimonial-slider-prev" aria-label="Previous testimonial" class="flex justify-center items-center hover:bg-[#46466D] hover:text-white border txs-rounded-9 cursor-pointer hover:border-[#46466D]/1 border-[#46466D]/50 !md:txs-w-28 txs-w-24 txs-h-24 !md:txs-h-25 txs-fs-12 font-extrabold text-[#259040] transition duration-300 ease-in-out">
			<svg class="!md:txs-w-14 txs-w-11" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
		</button>
		<button id="testimonial-slider-next" aria-label="Next testimonial" class="flex justify-center items-center hover:bg-[#46466D] hover:text-white border txs-rounded-9 cursor-pointer hover:border-[#46466D]/1 border-[#46466D]/50 !md:txs-w-28 txs-w-24 txs-h-24 !md:txs-h-25 txs-fs-12 font-extrabold text-[#259040] transition duration-300 ease-in-out">
			<svg class="!md:txs-w-14 txs-w-11" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
		</button>
	</div>

	<div id="testimonial-carousel" dir="ltr" class="flex justify-end w-full !md:txs-h-370 txs-h-258 relative overflow-x-auto overflow-y-hidden !md:txs-mt-50 !md:txs-pr-70 txs-pr-0 scrollbar-hide
		   transition-all duration-800 ease-out opacity-0 translate-y-8">
		<?php if (!empty($testimonials_looped)) : ?>
			<?php foreach ($testimonials_looped as $i => $slide_data) : ?>
				<?php
                $image = $slide_data['image'];
                $name = $slide_data['name'];
                $title = $slide_data['title'];
                $content = $slide_data['content'];
                ?>
				<div class="carousel-item relative flex-shrink-0 flex items-center w-full !md:txs-h-358 txs-h-248 !md:txs-w-695 !md:txs-pr-21 !md:txs-ml-41 transition-opacity duration-800">
					<div class="w-full h-full flex items-center md:px-0 px-5">
						<div class="relative w-full">
							<div class="absolute left-0 !md:txs-left-73 top-0">
                                <svg class="txs-w-78 md:txs-w-auto"  viewBox="0 0 78 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.10319e-06 17.4226C0.206633 17.4318 0.414927 17.436 0.62406 17.436L5.32242 17.436C15.9456 17.436 19.1092 7.52681 19.4842 -2.10857e-06C19.8599 7.52681 23.9442 17.436 33.6467 17.436L38.3459 17.436C38.5651 17.436 38.7834 17.431 39 17.4209L19.4992 37L2.10319e-06 17.4226Z" fill="#259040"/>
                                <path d="M39 17.4226C39.2066 17.4318 39.4149 17.436 39.6241 17.436L44.3224 17.436C54.9456 17.436 58.1092 7.52681 58.4842 -2.10857e-06C58.8599 7.52681 62.9442 17.436 72.6467 17.436L77.3459 17.436C77.5651 17.436 77.7834 17.431 78 17.4209L58.4992 37L39 17.4226Z" fill="#259040"/>
                                </svg>
							</div>
							<div class="absolute right-0 !md:txs-right-73 bottom-0">
								<svg class="txs-w-78 md:txs-w-auto"  viewBox="0 0 78 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.10319e-06 17.4226C0.206633 17.4318 0.414927 17.436 0.62406 17.436L5.32242 17.436C15.9456 17.436 19.1092 7.52681 19.4842 -2.10857e-06C19.8599 7.52681 23.9442 17.436 33.6467 17.436L38.3459 17.436C38.5651 17.436 38.7834 17.431 39 17.4209L19.4992 37L2.10319e-06 17.4226Z" fill="#259040"/>
                                <path d="M39 17.4226C39.2066 17.4318 39.4149 17.436 39.6241 17.436L44.3224 17.436C54.9456 17.436 58.1092 7.52681 58.4842 -2.10857e-06C58.8599 7.52681 62.9442 17.436 72.6467 17.436L77.3459 17.436C77.5651 17.436 77.7834 17.431 78 17.4209L58.4992 37L39 17.4226Z" fill="#259040"/>
                                </svg>
							</div>
							<div class="!md:txs-h-329 txs-h-229 txs-px-109 !md:txs-px-109 txs-py-52 !md:txs-py-52 bg-[#F8F8F8] !md:txs-rounded-45 txs-rounded-30">
								<div class="flex justify-start items-center">
									<?php if ($image) : ?>
										<img class="md:block hidden txs-w-293 txs-h-273 absolute right-0 txs-bottom-293 !md:txs-bottom-293 object-cover clipped-testimonial-image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
										<img class="md:hidden block w-28 h-24 absolute right-0 txs-bottom-293 !md:txs-bottom-293 object-cover clipped-testimonial-image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
									<?php endif; ?>
									<div class="txs-pr-15">
										<div class="txs-fs-16 font-semibold  text[#212529]">
											<?php echo esc_html($name); ?>
										</div>
										<div class="txs-fs-14 font-regular  text[#212529]">
											<?php echo esc_html($title); ?>
										</div>
									</div>
								</div>
								<div class="txs-fs-11 md:txs-fs-16 font-semibold txs-mt-18  text[#212529]">
									"<?php echo esc_html($content); ?>"
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>

<style>
:root {
    --tx-canvas-size: 1440;
    --tx: calc(100vw / var(--tx-canvas-size));
}

@media (max-width: 767px) {
    :root {
        --tx-canvas-size: 420 !important;
    }
}

.clipped-testimonial-image {
    -webkit-mask-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKcAAACYCAYAAACBOvmUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAU4SURBVHgB7d3NddtGFIbhL/EiW3eQ20HSQeAO3AHVQbLMTkwFcQdKKnBcAZUKJFdAqAKpAxnXBG1ZFkgCGABzOe9zzj2UfLgggdcDQvyTkIo1s2kvgWxYM9tmHttLE5AB09cw90OgWJzp+zAJFIszdYdJoFjM62ZudDjM/dy01wcm1ydMAsVshoRJoJjcmDAJFJNJESaBYhLvlSbM/VwJSMBDepxgCBSjTBUmgWKUqcMkUAwyV5gEil4uNW+Y+/lbwAFLhbmfSwEvWDpMAsWLcgmTQPGN3MIkUHyWa5gEWrjcwyTQQkUJk0AL4zs6QpAEWhjfwRFCJNDC/K5YIXbNSjgrvkMjhEeghfEdGSE4Ai2M78AIoRFoYXzHRQiMQAvzq2IFNnYqIQQP816x4ho79+39RsZKDJNAAyg5TALNGGESaJZMhPlSoCYsynT8MzJLna0IdDEmwiTQDJkIk0AzZCJMAs2QiTAJNEMmwiTQDJkIk0AzZCJMAs2QiTAJNEP+uem+ASPs6MiB8vn0PaX8ggDm8PAFCj0QJoFmiTAJNEuESaDZIsw8ZiN840qxduC5z5XwmW+ICDuMQAvjGyDCjiLQwvgdj7CDCLQw/p07UXYOs1CgrzS/y2b+FCLZv5vzf50xDzP3VYLpnkudKb9jEXYAU1igfocibHimsED9jkTY4ExhgfodiLChmcIC9RseYQMzhQXqNzjChmUKC9RvaIQNyhQWqN/ACBuSmWb+UKZWirUhmWlmpcz4DYqw4Zh5ZqVM+A2JsMGYeWelha0Ub6Mx881KC1kp7kZj5puVBvpBw/hLqDbinXo47qGZN83cqqchcRIm+hoUaN84CRND9Q60T5yEibF6BXpqnISJVE4O9JQ4TbswTUAatXaB1oeudCxOE2FiGrWOBHooThNhYlq1DgTaFaeJMDGPWh2BvhSniTAxr1ovBPo8ThNhYhm1ngX6NE4TYWJZtZ4Euo/TRJjIQ602UI/TRJjIS93MG49z3czPSs+eXL4Wzy6dk4d26vb3WundDXlV0lAep7XjT4f+8uRn5Klu5rqZu/bn2/byQTOYM84uHm3Vzm8i1iV5fP4xh9ftzBJhJNbMhXaPgx+ZSee+3c7+ll4edvVkItQpZiOCTMqa+Ue7/+1RIshpfLu9Ew+bJmXaraZbxYpjySjXYpWc3YWIlCgztxaHe6LMmGn3mDRSSKnnSkSZtUrlHeq37f1GEGvFCmzo+Bk4q2VAlc53Fd2K1TI8a+a9YoV3bDZitTwra8UKsGvWwll6q7h/cvLbfSGcNVO8x6Fb8bRjMUxxAt2KdykUx5R/oIRZMFO+gRImsgyUMPGFKZ9ACRPfMS3/Z6Z7ESY6VFo2zkrAAf7emiXCXAs4gb/SZ84w3wk4kb+o4kbzhLkV0JNp+hMkToAw2NSPP7P9fnLEsNE0YW4EjGRKf3jncI5kUh/e1wISSnX2vhWQWKU0cb4VMIGNxoV5JWAilcbFaQImNHT1ZNXE5CqxaiJjfVdPVk3MplK/OCsBMzp19dwKg/woDPXhxOv9JWBm/prPY8+534sP3BqMlXM4/wKpf49c5z/xRVNYSCVOhJCxrkM7J0IjcVgfr+vQfi1gYZV49REy1XXWjpE4rI/nZ+O3z/7tWhiNONP4cOR3DECcadwe+R1YjD/u5PEmsrV/A9yNkASH9XQ+tpcc0hMhznT2UX4UkiDOdOr2kpUzEeJMZx8lr0JCljhTT4iVM61rIRniTIuToYSIM61aSOaVkNJPzdwJSbByAgAAYGqfACDoAXJRoPg2AAAAAElFTSuQmCC');
    mask-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKcAAACYCAYAAACBOvmUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAU4SURBVHgB7d3NddtGFIbhL/EiW3eQ20HSQeAO3AHVQbLMTkwFcQdKKnBcAZUKJFdAqAKpAxnXBG1ZFkgCGABzOe9zzj2UfLgggdcDQvyTkIo1s2kvgWxYM9tmHttLE5AB09cw90OgWJzp+zAJFIszdYdJoFjM62ZudDjM/dy01wcm1ydMAsVshoRJoJjcmDAJFJNJESaBYhLvlSbM/VwJSMBDepxgCBSjTBUmgWKUqcMkUAwyV5gEil4uNW+Y+/lbwAFLhbmfSwEvWDpMAsWLcgmTQPGN3MIkUHyWa5gEWrjcwyTQQkUJk0AL4zs6QpAEWhjfwRFCJNDC/K5YIXbNSjgrvkMjhEeghfEdGSE4Ai2M78AIoRFoYXzHRQiMQAvzq2IFNnYqIQQP816x4ho79+39RsZKDJNAAyg5TALNGGESaJZMhPlSoCYsynT8MzJLna0IdDEmwiTQDJkIk0AzZCJMAs2QiTAJNEMmwiTQDJkIk0AzZCJMAs2QiTAJNEP+uem+ASPs6MiB8vn0PaX8ggDm8PAFCj0QJoFmiTAJNEuESaDZIsw8ZiN840qxduC5z5XwmW+ICDuMQAvjGyDCjiLQwvgdj7CDCLQw/p07UXYOs1CgrzS/y2b+FCLZv5vzf50xDzP3VYLpnkudKb9jEXYAU1igfocibHimsED9jkTY4ExhgfodiLChmcIC9RseYQMzhQXqNzjChmUKC9RvaIQNyhQWqN/ACBuSmWb+UKZWirUhmWlmpcz4DYqw4Zh5ZqVM+A2JsMGYeWelha0Ub6Mx881KC1kp7kZj5puVBvpBw/hLqDbinXo47qGZN83cqqchcRIm+hoUaN84CRND9Q60T5yEibF6BXpqnISJVE4O9JQ4TbswTUAatXaB1oeudCxOE2FiGrWOBHooThNhYlq1DgTaFaeJMDGPWh2BvhSniTAxr1ovBPo8ThNhYhm1ngX6NE4TYWJZtZ4Euo/TRJjIQ602UI/TRJjIS93MG49z3czPSs+eXL4Wzy6dk4d26vb3WundDXlV0lAep7XjT4f+8uRn5Klu5rqZu/bn2/byQTOYM84uHm3Vzm8i1iV5fP4xh9ftzBJhJNbMhXaPgx+ZSee+3c7+ll4edvVkItQpZiOCTMqa+Ue7/+1RIshpfLu9Ew+bJmXaraZbxYpjySjXYpWc3YWIlCgztxaHe6LMmGn3mDRSSKnnSkSZtUrlHeq37f1GEGvFCmzo+Bk4q2VAlc53Fd2K1TI8a+a9YoV3bDZitTwra8UKsGvWwll6q7h/cvLbfSGcNVO8x6Fb8bRjMUxxAt2KdykUx5R/oIRZMFO+gRImsgyUMPGFKZ9ACRPfMS3/Z6Z7ESY6VFo2zkrAAf7emiXCXAs4gb/SZ84w3wk4kb+o4kbzhLkV0JNp+hMkToAw2NSPP7P9fnLEsNE0YW4EjGRKf3jncI5kUh/e1wISSnX2vhWQWKU0cb4VMIGNxoV5JWAilcbFaQImNHT1ZNXE5CqxaiJjfVdPVk3MplK/OCsBMzp19dwKg/woDPXhxOv9JWBm/prPY8+534sP3BqMlXM4/wKpf49c5z/xRVNYSCVOhJCxrkM7J0IjcVgfr+vQfi1gYZV49REy1XXWjpE4rI/nZ+O3z/7tWhiNONP4cOR3DECcadwe+R1YjD/u5PEmsrV/A9yNkASH9XQ+tpcc0hMhznT2UX4UkiDOdOr2kpUzEeJMZx8lr0JCljhTT4iVM61rIRniTIuToYSIM61aSOaVkNJPzdwJSbByAgAAYGqfACDoAXJRoPg2AAAAAElFTSuQmCC');
    mask-size: 100% 100%;
    mask-repeat: no-repeat;
}

.txs-h-288 { height: calc(var(--tx) * 288); }
.txs-right-170 { right: calc(var(--tx) * 170); }
.txs-w-52 { width: calc(var(--tx) * 52); }
.txs-rounded-9 { border-radius: calc(var(--tx) * 9); }
.txs-w-24 { width: calc(var(--tx) * 24); }
.txs-h-24 { height: calc(var(--tx) * 24); }
.txs-fs-12 { font-size: calc(var(--tx) * 12); }
.txs-w-11 { width: calc(var(--tx) * 11); }
.txs-w-293 { width: calc(var(--tx) * 193); }
.txs-bottom-293 { bottom: calc(var(--tx) * 153);right: calc(var(--tx) * 33); }
.txs-h-258 { height: calc(var(--tx) * 258); }
.txs-h-273 { height: calc(var(--tx) * 173); }
.txs-pr-0 { padding-right: calc(var(--tx) * 0); }
.txs-h-248 { height: calc(var(--tx) * 248); }
.txs-w-78 { width: calc(var(--tx) * 78); }
.txs-h-229 { height: calc(var(--tx) * 229); }
.txs-rounded-30 { border-radius: calc(var(--tx) * 30); }
.txs-w-50 { width: calc(var(--tx) * 50); }
.txs-pr-15 { padding-right: calc(var(--tx) * 15); }
.txs-fs-16 { font-size: calc(var(--tx) * 20); }
.txs-fs-14 { font-size: calc(var(--tx) * 18); }
.txs-fs-11 { font-size: calc(var(--tx) * 12); }
.txs-mt-18 { margin-top: calc(var(--tx) * 18); }
.txs-py-52 { padding-top: calc(var(--tx) * 52) !important; padding-bottom: calc(var(--tx) * 52) !important; }
.txs-px-109 { padding-left: calc(var(--tx) * 34) !important; padding-right: calc(var(--tx) * 34) !important; }

@media (min-width: 768px) {
    .\!md\:txs-h-390 { height: calc(var(--tx) * 530) !important; }
    .txs-fs-11 { font-size: calc(var(--tx) * 14); }
    .\!md\:txs-right-100 { right: calc(var(--tx) * 100) !important; }
    .\!md\:txs-bottom-293 { bottom: calc(var(--tx) * 253);right: calc(var(--tx) * 33); }
    .\!md\:txs-w-60 { width: calc(var(--tx) * 60) !important; }
    .\!md\:txs-w-28 { width: calc(var(--tx) * 28) !important; }
    .\!md\:txs-h-25 { height: calc(var(--tx) * 25) !important; }
    .\!md\:txs-w-14 { width: calc(var(--tx) * 14) !important; }
    .\!md\:txs-h-370 { height: calc(var(--tx) * 510) !important; }
    .\!md\:txs-mt-50 { margin-top: calc(var(--tx) * 50) !important; }
    .\!md\:txs-pr-70 { padding-right: calc(var(--tx) * 70) !important; }
    .\!md\:txs-h-358 { height: calc(var(--tx) * 558) !important; }
    .\!md\:txs-w-695 { width: calc(var(--tx) * 695) !important; }
    .\!md\:txs-pr-21 { padding-right: calc(var(--tx) * 21) !important; }
    .\!md\:txs-ml-41 { margin-left: calc(var(--tx) * 41) !important; }
    .\!md\:txs-right-73 { right: calc(var(--tx) * 73) !important; }
    .\!md\:txs-left-73 { left: calc(var(--tx) * 73) !important; }
    .\!md\:txs-h-329 { height: calc(var(--tx) * 329) !important; }
    .\!md\:txs-px-109 { padding-left: calc(var(--tx) * 84) !important; padding-right: calc(var(--tx) * 84) !important; }
    .\!md\:txs-py-52 { padding-top: calc(var(--tx) * 104) !important; padding-bottom: calc(var(--tx) * 104) !important; }
    .\!md\:txs-rounded-45 { border-radius: calc(var(--tx) * 45) !important; }
    .\!md\:txs-fs-16 { font-size: calc(var(--tx) * 16) !important; }
}

.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
.scroll-smooth {
    scroll-behavior: smooth;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('testimonial-carousel');
    const nextButton = document.getElementById('testimonial-slider-prev');
    const prevButton = document.getElementById('testimonial-slider-next');

    if (!carousel || !prevButton || !nextButton) return;

    const slides = Array.from(carousel.querySelectorAll('.carousel-item'));
    if (slides.length === 0) return;

    const originalSlideCount = slides.length / 3;
    let currentSlide = originalSlideCount;
    let isDragging = false;
    let startX = 0;
    let startScrollLeft = 0;
    const intervalSeconds = 4;
    let intervalId = null;
    const animationDuration = 500;

    const goToSlide = (slideIndex, instant = false) => {
        const slide = slides[slideIndex];
        if (!slide) return;
        
        if (instant) {
            carousel.classList.remove('scroll-smooth');
        } else {
            carousel.classList.add('scroll-smooth');
        }
        carousel.scrollLeft = slide.offsetLeft;
    };

    const updateSlideOpacity = () => {
        const activeRealIndex = currentSlide % originalSlideCount;
        slides.forEach((slide, index) => {
            const slideRealIndex = index % originalSlideCount;
            if (slideRealIndex === activeRealIndex) {
                slide.classList.remove('opacity-30', 'pointer-events-none');
            } else {
                slide.classList.add('opacity-30', 'pointer-events-none');
            }
        });
    };

    const showNextSlide = () => {
        if (currentSlide >= slides.length - 1) return;
        currentSlide++;
        goToSlide(currentSlide);
        updateSlideOpacity();

        if (currentSlide >= originalSlideCount * 2) {
            setTimeout(() => {
                currentSlide = originalSlideCount;
                goToSlide(currentSlide, true);
            }, animationDuration);
        }
    };
    
    const showPrevSlide = () => {
        if (currentSlide <= 0) return;
        currentSlide--;
        goToSlide(currentSlide);
        updateSlideOpacity();

        if (currentSlide < originalSlideCount) {
            setTimeout(() => {
                currentSlide = (originalSlideCount * 2) - 1;
                goToSlide(currentSlide, true);
            }, animationDuration);
        }
    };

    const startInterval = () => {
        stopInterval();
        intervalId = setInterval(showNextSlide, intervalSeconds * 1000);
    };

    const stopInterval = () => {
        clearInterval(intervalId);
    };

    const handleDragStart = (e) => {
        isDragging = true;
        startX = e.pageX || e.touches[0].pageX;
        startScrollLeft = carousel.scrollLeft;
        stopInterval();
        carousel.classList.remove('scroll-smooth');
        carousel.classList.add('cursor-grabbing');
    };

    const handleDragMove = (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX || e.touches[0].pageX;
        const walk = (x - startX);
        carousel.scrollLeft = startScrollLeft - walk;
    };

    const handleDragEnd = (e) => {
        if (!isDragging) return;
        isDragging = false;
        carousel.classList.remove('cursor-grabbing');

        const clientX = e.pageX || e.changedTouches[0].pageX;
        const deltaX = clientX - startX;

        if (deltaX < -50) {
            showPrevSlide();
        } else if (deltaX > 50) {
            showNextSlide();
        } else {
            goToSlide(currentSlide);
        }

        startInterval();
    };

    const init = () => {
        goToSlide(currentSlide, true);
        updateSlideOpacity();
        startInterval();

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0', 'translate-y-8');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        observer.observe(carousel);

        nextButton.addEventListener('click', () => {
            stopInterval();
            showNextSlide();
            startInterval();
        });
        prevButton.addEventListener('click', () => {
            stopInterval();
            showPrevSlide();
            startInterval();
        });

        carousel.addEventListener('mousedown', handleDragStart);
        carousel.addEventListener('mousemove', handleDragMove);
        carousel.addEventListener('mouseup', handleDragEnd);
        carousel.addEventListener('mouseleave', handleDragEnd);
        
        carousel.addEventListener('touchstart', handleDragStart, { passive: true });
        carousel.addEventListener('touchmove', handleDragMove, { passive: false });
        carousel.addEventListener('touchend', handleDragEnd);

        carousel.querySelectorAll('img').forEach(img => img.addEventListener('dragstart', (e) => e.preventDefault()));
    };

    init();
});
</script> -->