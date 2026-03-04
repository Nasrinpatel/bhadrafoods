@php
    $footerColor = Theme::get('footerColor');
@endphp
<style>
    :root {
        --footer-background-color: {{ theme_option('footer_background_color', '#F8F8F8') }};
        --footer-text-color: {{ theme_option('footer_text_color', '#000000') }};
        --footer-text-muted-color: {{ theme_option('footer_text_muted_color', '#686666') }};
        --footer-border-color: {{ theme_option('footer_border_color', '#E0E0E0') }};
        --footer-bottom-background-color: {{ theme_option('footer_bottom_background_color', '#ededed') }};
        --footer-bottom-text-color: {{ theme_option('footer_bottom_text_color', '#ffffff') }};
    }
    .footer-area{
        background-color: var(--footer-background-color);
        color: var(--footer-text-color);
    }
    .footer-copyright {
        background-color: var(--footer-bottom-background-color);
        color: var(--footer-bottom-text-color);
    }
</style>
<footer>
    <div
        class="footer-area pt-65"
    >
        <div class="container">
            <div class="main-footer pb-15 mb-30">
                <div class="row">
                    {!! dynamic_sidebar('footer_sidebar') !!}
                </div>
            </div>
            <div class="footer-cta pb-20">
                <div class="row justify-content-between align-items-center">
                    {!! dynamic_sidebar('footer_middle_sidebar') !!}
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    {!! dynamic_sidebar('footer_bottom_sidebar') !!}
                </div>
            </div>
        </div>
    </div>
</footer>
