interface PopularCategoriesMobileContainerProps {
  children: React.ReactNode;
}

const PopularCategoriesMobileContainer = ({
  children,
}: PopularCategoriesMobileContainerProps) => {
  return (
    <section className="ui-container mb-4 hide-scrollable">
      <div className="flex">{children}</div>
    </section>
  );
};

export default PopularCategoriesMobileContainer;
