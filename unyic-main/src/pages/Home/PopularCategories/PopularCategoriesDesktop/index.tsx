
import PopularCategoriesGrid from "./PopularCategoriesGrid";

const PopularCategoriesDesktop = () => {
  return (
    <section className="mt-responsive ui-container">
      <header className="text-center mb-10">
        <h3 className="text-2xl sm:text-3xl font-medium">Popular Categories</h3>
      </header>

      <PopularCategoriesGrid />
    </section>
  );
};

export default PopularCategoriesDesktop;
