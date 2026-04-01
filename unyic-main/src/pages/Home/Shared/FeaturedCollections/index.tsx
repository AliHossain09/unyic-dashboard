import CollectionsCard from "./CollectionsCard";

export interface CollectionItem {
  href: string;
  imgSrc: string;
  title: string;
  brand: string;
  description: string;
}

const featuredCollectionsData: CollectionItem[] = [
  {
    href: "/c/zar",
    imgSrc:
      "https://imagescdn.jaypore.com/uploads/micrositmedia/production/12092024EVENT_01_M_3771_1726135957909.jpg?w=279&auto=format",

    title: "Zar",
    brand: "JAYPORE",
    description:
      "Silhouettes festooned with gilded threads & cut dana embroidery",
  },
  {
    href: "/c/kimaya",
    imgSrc:
      "https://imagescdn.jaypore.com/uploads/micrositmedia/production/12092024EVENT_02_M_3771_1726136004763.jpg?w=279&auto=format",

    title: "Kimaya",
    brand: "JAYPORE",
    description: "Eternally elegant gilded silver kundan inlay earrings",
  },
  {
    href: "/c/handwoven-traditions",
    imgSrc:
      "https://imagescdn.jaypore.com/uploads/micrositmedia/production/12092024EVENT_03_M_3771_1726136058824.jpg?w=279&auto=format",

    title: "Handwoven Traditions",
    brand: "PASHMELADAKH",
    description:
      "Wrap yourself in exquisite handwoven & hand embroidered woolen shawls",
  },
  {
    href: "/c/sophisticated-settings",
    imgSrc:
      "https://imagescdn.jaypore.com/uploads/micrositmedia/production/12092024EVENT_04_3771_1726136119067.jpg?w=279&auto=format",

    title: "Sophisticated Settings",
    brand: "THE WISHING CHAIR",
    description:
      "Embroidered & hand woven wall accents, cushion covers & more to accentuate the interiors",
  },
];

const FeaturedCollections = () => {
  return (
    <section>
      <header className="ui-container mb-8 text-center">
        <h3 className="text-2xl lg:text-3xl">Featured Collections</h3>
      </header>

      <div className="ui-container !mt-0 grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8">
        {featuredCollectionsData.map((item) => (
          <CollectionsCard key={item.href} item={item} />
        ))}
      </div>

      <figure className="mt-responsive">
        <img
          src="https://imagescdn.jaypore.com/uploads/micrositmedia/production/26082024_Festive_Skinny_Banner_Mobile_3771_1724390387562.jpg?w=600&auto=format"
          alt="Festive Collection Banner"
          className="w-full lg:hidden"
        />

        <img
          src="https://imagescdn.jaypore.com/uploads/micrositmedia/production/26082024_Festive_Skinny_Banner_Desktop_3771_1724390291925.jpg?w=1900&auto=format"
          alt="Festive Collection Banner"
          className="w-full hidden lg:block"
        />
      </figure>

      <div className="ui-container grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8">
        {featuredCollectionsData.map((item) => (
          <CollectionsCard key={item.href} item={item} />
        ))}
      </div>
    </section>
  );
};

export default FeaturedCollections;
