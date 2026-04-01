import { Link } from "react-router";


const collectionsData = [
  {
    image:
      "https://imagescdn.jaypore.com/img/app/micrositemedia/production/designsIcon_262_16904549538211698333343.png",
    title: "Unique and exclusive collections",
  },
  {
    image:
      "https://imagescdn.jaypore.com/img/app/micrositemedia/production/craftsIcon_262_16904548674881698333281.png",
    title: "Age old crafts",
  },
  {
    image:
      "https://imagescdn.jaypore.com/img/app/micrositemedia/production/collectionsIcon_262_16904547695551698333210.png",
    title: "Contemporary designs",
  },
  {
    image:
      "https://imagescdn.jaypore.com/img/app/micrositemedia/production/communitiesIcon_262_16904550512851698333394.png",
    title: "Artisanal communities",
  },
];

const CollectionHighlights = () => {
  return (
    <section
      className="mt-14 md:mt-16 lg:mt-20 py-10 text-center text-primary flex flex-wrap justify-center items-center gap-16"
      style={{
        backgroundImage:
          "linear-gradient(270deg, rgba(187,65,37,.078), hsla(0,2%,67%,.051), rgba(187,65,37,.078))",
      }}
    >
      {collectionsData.map((collection, index) => (
        <Link key={index} to={``} title={collection?.title}>
          <figure>
            <img
              src={collection?.image}
              className="mx-auto w-auto h-auto max-w-full"
              alt={collection?.title}
              width="100"
              height="100"
            />
            <figcaption className="mt-2">{collection?.title}</figcaption>
          </figure>
        </Link>
      ))}
    </section>
  );
};

export default CollectionHighlights;
