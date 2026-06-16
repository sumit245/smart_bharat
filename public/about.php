<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('partials/icons.php');
$pageKey = 'about';
$site = config('site');
$extraJsonLd = function () {
  render_jsonld_breadcrumb([
    ['name' => 'Home', 'href' => '/'],
    ['name' => 'About Us', 'href' => '/about'],
  ]);
};
partial('header', compact('pageKey', 'extraJsonLd'));

$impactStats = [
  ['value' => '650+', 'label' => 'media portals connected'],
  ['value' => '400M+', 'label' => 'combined digital reach'],
  ['value' => '500+', 'label' => 'journalists trained'],
  ['value' => 'Global', 'label' => 'media collective mindset'],
];

$principles = [

  [
    'icon' => 'globe',
    'title' => 'Global Media Collective',
    'text' => 'A connected platform for Bharatiya, Indic, and nationalistic media voices that want credible narratives to travel beyond isolated audiences.',
  ],
  [
    'icon' => 'book',
    'title' => 'Indic Knowledge & Virtues',
    'text' => 'Content rooted in civilisational values: satvik lifestyle, inclusiveness, Vasudhaiva Kutumbakam, respect for ecology, and dignity for all life.',
  ],
  [
    'icon' => 'users',
    'title' => 'Support for Media Owners',
    'text' => 'Intellectual, legal, operational, and material support for independent publishers, creators, knowledge providers, and digital news platforms.',
  ],
  [
    'icon' => 'megaphone',
    'title' => 'Amplification With Purpose',
    'text' => 'Shared research, campaign coordination, and distribution strength help important national issues get the frequency and reach they deserve.',
  ],
];

$supportAreas = [
  ['title' => 'Research & Advisory', 'text' => 'Issue briefs, content context, narrative mapping, and advisory support for media teams covering matters of national importance.'],
  ['title' => 'Training & Capacity Building', 'text' => 'Practical sessions for editorial quality, fact checking, audience growth, digital publishing, and responsible platform use.'],
  ['title' => 'Financial & Resource Synergy', 'text' => 'A cooperative model that helps independent Bharatiya media organisations remain sustainable without losing their voice.'],
  ['title' => 'Directory & Trust Network', 'text' => 'A public ecosystem of vetted nationalistic portals, knowledge providers, friends of SMaRT, and aligned media partners.'],
];
?>

<section class="page-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / About Us</nav>
    <h1>An Institution Ready to Back You</h1>
    <p>Registered non-profit. Free membership. Five years of standing behind India's most authentic voices.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="mission">
      <div class="reveal">
        <span class="mission__eyebrow">Our Story</span>
        <h2>Born on Dusherra. Built for Every Creator.</h2>
        <p>On Dusherra, <?= e(date('Y', strtotime($site['founded']))) ?>, we invited 25 media members across India with
          a simple belief that India's authentic voices deserved more than passion. They deserved an institution.</p>
        <p>Five years later, SMaRT is that institution — 650+ members strong, spanning grassroots regional creators and
          elite national platforms, united by one commitment: to tell Bharat's story on Bharat's own terms.</p>
        <!-- <p>Samachar Manyata Association for Research and Training exists to help nationalistic media organisations, regional news portals, YouTube channels, cartoonists, meme pages, print publications, knowledge partners, and friends of SMaRT collaborate without becoming dependent on a single editorial command.</p> -->
      </div>
      <div class="mission__diagram reveal" aria-hidden="true">
        <?= file_get_contents(app_root() . '/public/assets/img/force-multiplier.svg') ?>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="about-intro reveal">
      <div>
        <span class="section__eyebrow">Why SMaRT?</span>
        <h2 class="section__title">We Back. We Don't Direct.</h2>
      </div>
      <div class="about-intro__copy">
        <p>SMaRT does not tell its members what to say. We give them what they need to say it better — research grants,
          legal support, literary platforms, cultural immersions, and coordinated amplification. Every member retains
          complete editorial independence.</p>
        <!-- <p>Independent media often works in silos. SMaRT makes those voices stronger through a global media collective
          platform: research support, training, amplification, shared learning, and practical cooperation between
          publishers and knowledge providers.</p> -->
      </div>
    </div>
    <div class="about-metrics reveal">
      <?php foreach ($impactStats as $stat): ?>
        <div class="about-metric">
          <strong><?= e($stat['value']) ?></strong>
          <span><?= e($stat['label']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--navy about-purpose">
  <div class="container">
    <div class="section__head reveal">
      <span class="section__eyebrow">Purpose, Approach, Role</span>
      <h2 class="section__title">Advancing Indic Knowledge Through Media Cooperation</h2>
      <p class="section__lede">The live SMaRT idea is simple: help credible voices help each other, so national
        discourse gains scale without losing rootedness.</p>
    </div>
    <div class="about-purpose__grid">
      <article class="about-purpose__card reveal">
        <span>01</span>
        <h3>Purpose</h3>
        <p>Disseminate Indic knowledge and virtues through a global media collective that reflects civilisational
          values, inclusiveness, the idea that the world is one family, respect for all life, and care for ecology.</p>
      </article>
      <article class="about-purpose__card reveal" style="transition-delay:60ms">
        <span>02</span>
        <h3>Approach</h3>
        <p>Aid nationalistic media and knowledge providers intellectually, legally, operationally, and materially
          through research, training, resources, and coalition-led media support.</p>
      </article>
      <article class="about-purpose__card reveal" style="transition-delay:120ms">
        <span>03</span>
        <h3>Role</h3>
        <p>Provide advisory and research strength so independent media owners can publish with better context, stronger
          evidence, and wider distribution across Bharat and global audiences.</p>
      </article>
    </div>
  </div>
</section>

<section class="section section--bg">
  <div class="container">
    <div class="section__head reveal">
      <span class="section__eyebrow">What We Stand For</span>
      <h2 class="section__title">Our Values</h2>
    </div>
    <div class="card-grid card-grid--3">
      <article class="card reveal">
        <div class="card__icon card__icon--saffron"><?php icon('book', ['width' => 28, 'height' => 28]); ?></div>
        <h3 class="card__title">Civilisational Rooting</h3>
        <p class="card__summary">India's knowledge systems are living intelligence.</p>
      </article>
      <article class="card reveal" style="transition-delay:60ms">
        <div class="card__icon card__icon--navy"><?php icon('users', ['width' => 28, 'height' => 28]); ?></div>
        <h3 class="card__title">Editorial Independence</h3>
        <p class="card__summary">SMaRT enables. Never dictates.</p>
      </article>
      <article class="card reveal" style="transition-delay:120ms">
        <div class="card__icon card__icon--saffron"><?php icon('check', ['width' => 28, 'height' => 28]); ?></div>
        <h3 class="card__title">Free & Open</h3>
        <p class="card__summary">No fees. No barriers. No exceptions.</p>
      </article>
      <article class="card reveal" style="transition-delay:120ms">
        <div class="card__icon card__icon--navy"><?php icon('check', ['width' => 28, 'height' => 28]); ?></div>
        <h3 class="card__title">Legal Courage</h3>
        <p class="card__summary">We stand with creators who are targeted for speaking truthfully.</p>
      </article>
      <article class="card reveal" style="transition-delay:120ms">
        <div class="card__icon card__icon--saffron"><?php icon('check', ['width' => 28, 'height' => 28]); ?></div>
        <h3 class="card__title">Grassroots to Elite</h3>
        <p class="card__summary">From a village content creator to a national literary voice — SMaRT serves both with
          equal seriousness.</p>
      </article>

    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section__head reveal">
      <span class="section__eyebrow">How the Coalition Works</span>
      <h2 class="section__title">Built for Independent Bharatiya Media</h2>
      <p class="section__lede">SMaRT supports media members without replacing their identity, ownership, audience, or
        editorial judgment.</p>
    </div>
    <div class="card-grid card-grid--4">
      <?php foreach ($principles as $i => $item): ?>
        <article class="card reveal" style="transition-delay:<?= (int) ($i * 50) ?>ms">
          <div class="card__icon <?= $i % 2 === 0 ? 'card__icon--saffron' : 'card__icon--navy' ?>">
            <?php icon($item['icon'], ['width' => 28, 'height' => 28]); ?>
          </div>
          <h3 class="card__title"><?= e($item['title']) ?></h3>
          <p class="card__summary"><?= e($item['text']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--bg">
  <div class="container">
    <div class="mission mission--reverse">
      <div class="about-support reveal">
        <span class="mission__eyebrow">Member Support</span>
        <h2>Helping Each Other Makes the Media Ecosystem Stronger</h2>
        <p>SMaRT believes equality is strength. More research, more content sharing, better coordination, and wider
          media literacy create more awareness in society.</p>
        <p>For publishers, creators, and knowledge partners, that means practical support: discoverable directory
          presence, reliable research inputs, training opportunities, coalition relationships, and a network that
          understands nationalistic digital media.</p>
        <a class="btn btn--primary" href="/my-account">Join or Login
          <?php icon('arrow-right', ['width' => 20, 'height' => 20]); ?></a>
      </div>
      <div class="about-support__list reveal">
        <?php foreach ($supportAreas as $area): ?>
          <article>
            <h3><?= e($area['title']) ?></h3>
            <p><?= e($area['text']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section about-cta">
  <div class="container">
    <div class="about-cta__inner reveal">
      <div>
        <span class="section__eyebrow">Join the Movement</span>
        <h2>Be Part of a Stronger Nationalistic Media Network</h2>
        <p>Whether you run a news website, regional portal, YouTube channel, print publication, creative page, or
          knowledge initiative, SMaRT gives you a coalition that values independence and works for impact.</p>
      </div>
      <div class="about-cta__actions">
        <a class="btn btn--primary" href="/join">Join the Coalition
          <?php icon('arrow-right', ['width' => 20, 'height' => 20]); ?></a>
        <a class="btn btn--ghost" href="/directory">Explore Directory</a>
      </div>
    </div>
  </div>
</section>

<?php partial('footer'); ?>