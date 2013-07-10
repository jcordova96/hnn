<?php
/**
 * User: dataskills dataskills@gmail.com
 * Date: 7/9/13
 * Time: 3:19 PM
 */
?>
<h1 class="invert">Donations</h1>
<div class="hnn-class field-content">
    <p><strong>HNN depends on the generosity of its community of readers. If you like
            HNN please consider making a donation today! </strong></p>

                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post"><p><input name=" cmd"
                                                                                                         type="hidden"
                                                                                                         value="_s-xclick">
                                    <input name="hosted_button_id" type="hidden" value="7B73XPHNXTBGG"> <input
                                        alt="PayPal - The safer, easier way to pay online!" border="0" name="submit"
                                        src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" type="image"> <img
                                        alt="" border="0" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif"
                                        width="1"></p></form>
                            <p>HNN provides multiple ways to make a donation:</p>

                            <p>You can make a donation online through PayPal using the link above or through Fundly
                                using the form conveniently supplied below.</p>

                            <p>Or: &nbsp;You can send us a check using old-fashioned snail mail:</p>

                            <p style=""><b>History News Network<br> 119 South Main St.<br> Suite 220<br> Seattle, WA
                                    98104</b></p>

                            <p>Interested in donating stocks, bonds, land, or real estate to the HNN endowment? <a
                                    href="mailto:editor@hnn.us?subject=Donating%20stocks%2C%20bonds%2C%20land%2C%20or%20real%20estate">Contact
                                    us</a> to find out how. We also can help with <a
                                    href="http://hnn.us/articles/become-hnn-legacy-donor">legacy planning</a>.</p>

                            <p>HNN is a 501 (c)(3) non-profit. ALL DONATIONS ARE TAX DEDUCTIBLE! All you have to do to
                                satisfy Uncle Sam is keep a record of your transaction: a bank or credit card statement
                                is sufficient.</p></td>
                        <td valign="top" width="395"><p align=""><strong>Testimonials</strong></p>

                            <p align="">"I find the History News Network indispensable for keeping up with new
                                publications and new interpretations, and keeping track of debates over history, in both
                                its academic and public forms, throughout the world." — Eric Foner</p>

                            <p>"As its wide coverage and its impressive numbers of hits-per-week indicate, HNN has
                                become the most important -- and reliable -- source for fresh historical interpretation
                                and, of special note, for the understanding of current events placed, often
                                provocatively, in their historical contexts." — Walter LaFeber</p>
    <p>&nbsp;</p>

    <p>

    <div id="fundly-widget">
        <iframe id="fundly-widget-iframe-vaAtJN" name="fundly-widget-iframe-vaAtJN"
                src="https://fundly.com/vaAtJN/widgets/donation_page?url=http%3A%2F%2Fhnn.us%2Fdonate&amp;width=994"
                frameborder="0" style="height: 100%; width: 100%; border: none;"></iframe>
    </div>
    <script type="text/javascript" src="https://fundly.com/widget/javascripts/loader.js?wid=vaAtJN"
            id="fundly-widget-loader"></script>
    </p>
    <div id="fundly-link" style="font-family: 'lucida grande',Tahoma,Verdana; font-size: 12px; color: rgb(34, 34, 34);">
        Powered by <a href="https://fundly.com">Fundly</a></div>
    <div id="hiddenlpsubmitdiv" style="display: none;">&nbsp;</div>
    <script>
        try
        {
            for (var lastpass_iter = 0; lastpass_iter < document.forms.length; lastpass_iter++)
            {
                var lastpass_f = document.forms[lastpass_iter];
                if (typeof(lastpass_f.lpsubmitorig2) == "undefined")
                {
                    lastpass_f.lpsubmitorig2 = lastpass_f.submit;
                    lastpass_f.submit = function ()
                    {
                        var form = this;
                        var customEvent = document.createEvent("Event");
                        customEvent.initEvent("lpCustomEvent", true, true);
                        var d = document.getElementById("hiddenlpsubmitdiv");
                        for (var i = 0; i < document.forms.length; i++)
                        {
                            if (document.forms[i] == form)
                            {
                                d.innerText = i;
                            }
                        }
                        d.dispatchEvent(customEvent);
                        form.lpsubmitorig2();
                    }
                }
            }
        } catch (e)
        {
        }</script>
    <div id="disqus_thread">
        <iframe id="dsq1" data-disqus-uid="1" allowtransparency="true" frameborder="0" role="application" width="100%"
                src="http://mediacdn.disqus.com/1373331090/build/next-switches/client.html?disqus_version=1373331090#1"
                style="width: 100%; border: none; overflow: hidden; height: 0px; display: none;"></iframe>
        <iframe id="dsq4" data-disqus-uid="4" allowtransparency="true" frameborder="0" role="complementary" width="100%"
                src="http://disqus.com/embed/comments/?f=hnndev&amp;t_i=node%2F149637&amp;t_u=http%3A%2F%2Fhnn.us%2Fdonate&amp;t_e=Donate%20to%20HNN&amp;t_d=Donate%20to%20HNN%20%7C%20History%20News%20Network&amp;t_t=Donate%20to%20HNN&amp;s_o=default&amp;disqus_version=1373331090#4"
                style="width: 100%; border: none; overflow: hidden; height: 534px;" scrolling="no"
                horizontalscrolling="no" verticalscrolling="no"></iframe>
    </div>
    <noscript>&lt;div class="disqus-noscript"&gt;&lt;a href="http://hnndev.disqus.com/?url=http%3A%2F%2Fhnn.us%2Fdonate"&gt;View
        the discussion thread.&lt;/a&gt;&lt;/div&gt;</noscript>
</div>