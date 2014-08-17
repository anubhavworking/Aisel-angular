<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\PageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Aisel\PageBundle\Entity\Page;

/**
 * Page fixtures
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class LoadPageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $loremIpsumText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consectetur dolor eget viverra commodo. Ut vehicula volutpat massa. Maecenas congue sed risus ut semper. Fusce blandit sem nunc, nec facilisis neque eleifend eget. Pellentesque fringilla velit enim, vel convallis libero ultrices vel. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas consectetur lacus et nibh facilisis, non vulputate urna convallis. Donec quis dictum magna, id dictum urna. Aliquam euismod sit amet arcu vulputate laoreet. Vivamus at leo nibh. Proin scelerisque orci sit amet sem varius, a porttitor tortor iaculis. Aenean sollicitudin diam sed euismod varius. Duis commodo a metus eu scelerisque. Etiam porttitor placerat urna vel tincidunt. Quisque congue tellus quam, non volutpat justo eleifend vehicula. Phasellus cursus convallis aliquam. Morbi adipiscing vulputate tellus, id auctor metus interdum a. Fusce diam tellus, varius commodo tincidunt in, ornare a mauris. Phasellus interdum, metus non fringilla rhoncus, odio massa pharetra orci, in semper tortor enim nec quam. Duis consectetur quis nibh at convallis. Integer tincidunt ligula sem, vitae bibendum sem elementum nec. Etiam ornare nisl lacinia, facilisis nisl a, mollis sem. Aliquam erat volutpat.';

        // references
        $frontendUser = $this->getReference('frontenduser');
        $rootCategory = $this->getReference('root-category');
        $childCategory = $this->getReference('child-category');

        // Hidden About page
        $hiddenPage = new Page();
        $hiddenPage->setTitle('About Us');
        $hiddenPage->setContent('If you are designing a website and need to show what it will look like on the MacBook without actually using one, a mockup can be an excellent option. Although there are numerous places on the web that offer these mockups, we take pride in being the very best. All of our mockups are high quality and guaranteed to meet the needs of our customers. A good mockup can go a long way towards impressing clients, especially if you are involved in the designing of a new application or website. Technology has come a long way in recent years, and these mockups help to supplement the tools that these designers use to create innovative new apps. Anyone who is designing an application for the Apple iPad and needs to show their clients in a way that looks finished and polished will definitely want to consider using our generator, as it is a great way to go about doing this. Clients respond the best to apps they can see on the device, or at least an image of the device. We specialize in providing designers with a way to showcase their hard work on a variety of Apple devices, including the iPad and iPad Mini models. Allow your clients to see what you have created with one of our high quality mockups which will give them a much better idea as to what the app looks like and how it functions.');
        $hiddenPage->setStatus(true);
        $hiddenPage->setHidden(true);
        $hiddenPage->setCommentStatus(true);
        $hiddenPage->setMetaUrl('about-aisel');
        $hiddenPage->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $hiddenPage->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($hiddenPage);
        $manager->flush();
        $this->addReference('about-page', $hiddenPage);

        // Disabled page
        $page = new Page();
        $page->setTitle('Disabled Page');
        $page->setContent($loremIpsumText);
        $page->setStatus(false);
        $page->setHidden(true);
        $page->setCommentStatus(false);
        $page->setMetaUrl('page-disabled');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        // Pages
        $page = new Page();
        $page->setTitle('Sample Page 1');
        $page->setContent('Anyone who has designed an application and needs to showcase it to clients will need to consider the immense benefits of using a Macbook mockup. These mockups are realistic high quality representations of Apple devices which can be very useful when it comes to showing clients what you have created. Whether it is an app for finding restaurants in a given area or social networking, our mockups are the very best and can provide designers with the perfect way to go about showing their clients what they have made while saving a lot of time in the process.An iPhone mockup can be of great use to designers who are looking to impress their clients with a high quality visual representation of the apps they create. We offer mockups for the iPhone 4 and 5 from numerous angles with different backgrounds which will be sure to please your clients by giving them a better idea as to what your finished application is going to look like on the actual device. Mockups are definitely an important part of presenting finished or prototype applications, and we specialize in meeting the needs of designers that have to bring something to their clients in an official presentation.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-1');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample Page 2');
        $page->setContent('One of the primary benefits of the Macbook mockups we offer is that they are able to save designers a lot of time, which can be a great thing, especially considering all of the work that goes into creating and tweaking a single application until it is completed. We offer four different Macbook mockups for the Macbook Air and Pro models. These mockups can be of great use to those who are designing an app and need a way to show their clients what it looks like on the actual device without spending a lot of money.Going through our website you will be able to generate iPhone mockups from either an image on your computer or even a screenshot. These mockups are a must have for designers who want to save both time and money. Designing and creating a new mobile application can take a long time, which is why mockups can be so incredibly useful. By showing a few iPhone mockups to your clients, they will be able to get a sense as to what the overall design is like before you actually finish it.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-2');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample Page 3');
        $page->setContent('Our Macbook mockups are available in high quality 1024x768 resolution for maximum detail and enhanced visuals. It can be difficult to simply explain an app to a client, which is why a visual representation like the kind a mockup can offer is so useful. Whatever type of application you have created, it will be important that you represent it properly to the clients. You will find that our Macbook mockups come in a variety of angles with different backgrounds to choose from so you can find the perfect one for your presentation.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-3');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample Page 4');
        $page->setContent('Every application designer needs to have high quality mockups for the device that they are designing it for, which is where we come in. We have the best Apple device mockups on the internet, including those which are for the Macbook Pro and Air, for designers who really want to impress their clients. All you have to do is simply choose a photo or screen shot of your app and in minutes you will receive the finished product to use in your presentation. We take pride in providing our customers with high quality products which have been used by countless designers as well as students who need these visual representations for showcasing purposes.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-4');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample Page 5');
        $page->setContent('Those who design anything from logos to applications will most likely be interested in the mockups we have to offer. We have mockups which are design specifically for those who want to make it look as if their app, logo, or website is appearing on an actual MacBook. We have mockups for the MacBook Air as well as the Pro models, so you can choose exactly what you want. Our mockups also come in 1366x768 resolutions, making them truly high quality images which are perfect for presentations.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-5');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample Page 6');
        $page->setContent('If you need to show your client what you have accomplished so far, it will be important that you have something visual to put in front of them. You can talk about how great your application looks and how innovative it is, but your client simply won’t be convinced unless you have something to show them. Designers have been using our mockups to show their clients in presentations for a while now, and they are the best that are available on the internet by far.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-6');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample Page 7');
        $page->setContent('When you use our website you can choose to upload an existing image on your computer or use a screen shot from the web to generate your mockup. It only takes a few minutes to receive the mockup after the image has been uploaded, so you don’t have to wait very long to get it. Those who have an important presentation where they need to give a visual representation of the app they are designing will find that our mockups are extremely useful. We can guarantee your satisfaction when it comes to generating a mockup that will be incredibly convincing and effective at showing what your app is going to look like after it has been completed.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-7');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample Page 8');
        $page->setContent('One of the other reasons why our website is so popular with professional designers who need mockups made is because we offer a free and simple process for getting them. Using mockups can save a ton of time and effort, so it is definitely wise to consider using them, especially if you have a presentation with clients coming up in the near future. You will find that using these mockups can be a great way to go about showcasing your work for the people who have hired you to design a new logo for their product or an app which is made to be used on the MacBook.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-8');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample Page 9');
        $page->setContent('Those who need to design a new app to be used on the Apple iPad will find that having a mockup of this device will help out quite a bit. Designing a program of any kind for a mobile device, whether it is for social media or GPS, can be quite difficult with the proper visualization. The iPad mockups that we offer are high quality and can help designers to transform the ideas in their mind into a reality.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-9');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample Page 10');
        $page->setContent('Designers who want to save as much time as possible when it comes to designing new apps for the iPad will find that our mockups are the very best way to go about doing this. Our mockup generation tools can provide program designers with a great way to go about seeing what their app is like in practice and on the screen so all the necessary improvements and adjustments can be made. These mockups can really help those who need to design an app which is completely flawless by giving them a way to see it visually and not just in code.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-10');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample Page 11');
        $page->setContent('Our iPad mockups can help designers with testing their application prototypes in a way that is easier and more straightforward than any other. Your iPad mockup will be ready within a matter of minutes after placing your order, so you can get started on designing your app as soon as possible. It is certainly important to please your clients, and the mockups that we offer are the very best on the web. You will find that these mockups are detailed and can be of great use when it comes to the design process.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('page-11');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        // User Pages
        $page = new Page();
        $page->setTitle('Sample User Page One');
        $page->setContent('Using a mockup can also help with the design process by helping the developer identify flaws which can be fixed before the actual work begins. Chances are your clients will want something to look at the initial stages of the design/development of your application, which is why mockups can be so useful. Anyone who needs an iPhone mockup made will be able to rely on us to provide ones that are extremely high quality with a resolution of 640x1136. The quality of your mockups will definitely be important, which is why we make sure that all of ours have an enhanced look for clear visibility.');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->setFrontenduser($frontendUser);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('userpage-one');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

        $page = new Page();
        $page->setTitle('Sample User Page Two');
        $page->setContent('Whether you need a mockup for the iPhone 4 or 5, we can provide you with exactly what you are looking for. When it comes to program designing, mockups are an essential aspect of presentation. If you want to showcase your work to clients, this is most definitely the way to do it. Your mockups will provide your clients with a first glance at what your apps look like on the actual phone without having to actually spend the money on one of these devices. All of our mockups are free and offer everything that you need as a professional designer. ');
        $page->setStatus(true);
        $page->setHidden(false);
        $page->setFrontenduser($frontendUser);
        $page->addCategory($rootCategory);
        $page->addCategory($childCategory);
        $page->setCommentStatus(true);
        $page->setMetaUrl('userpage-two');
        $page->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $page->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));
        $manager->persist($page);
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 210;
    }
}
