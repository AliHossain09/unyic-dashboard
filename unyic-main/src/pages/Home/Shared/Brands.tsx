import { PiTriangleFill } from "react-icons/pi";
import { Link } from "react-router";

const brandsData = [
  {
    title: "PS Peaches",
    imgSrc:
      "https://imagescdn.jaypore.com/uploads/micrositmedia/production/1_355x263_showcasedBrand_Mobile_2_3771_1725531292163.png?w=583&auto=format",
    link: "/b/ps-peaches",
    alt: "PS Peaches",
  },
  {
    title: "Abhishti",
    imgSrc:
      "https://imagescdn.jaypore.com/uploads/micrositmedia/production/2_355x263_showcasedBrand_Mobile_2_3771_1725531505234.png?w=583&auto=format",
    link: "/b/abhishti?page=1&fp[]=Subbrand__fq%3AAbhishti&orderby=position&orderway=desc",
    alt: "Abhishti",
  },
];

const Brands = () => {
  return (
    <section>
      <header className="ui-container mb-8 text-center">
        <p className="uppercase">Brands</p>
        <h3 className="text-2xl lg:text-3xl text-center flex justify-center gap-2 mt-3">
          In the
          <span className="flex items-center gap-2 text-primary-dark">
            <PiTriangleFill className="-rotate-90 text-[28px]" />
            <span>Spotlight</span>
            <PiTriangleFill className="rotate-90 text-[28px]" />
          </span>
        </h3>
      </header>

      <div className="ui-container !mt-0 grid md:grid-cols-2 gap-4 lg:gap-8">
        {brandsData.map((brand, index) => (
          <article key={index}>
            <Link to={brand.link} title={brand.title}>
              <img
                src={brand.imgSrc}
                alt={brand.alt}
                className={`w-full ${index === 0 && "rounded-ss-[80px]"} ${
                  index === brandsData.length - 1 && "rounded-ee-[80px]"
                }`}
              />
            </Link>

            <div>
              <h5 className="text-xl my-1">{brand.title}</h5>
              <Link
                to={brand.link}
                title={`Shop Now for ${brand.title}`}
                className="text-primary underline"
              >
                Shop Now
              </Link>
            </div>
          </article>
        ))}
      </div>
    </section>
  );
};

export default Brands;
