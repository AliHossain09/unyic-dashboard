import FooterLinks from "./FooterLinks";
import shipping from "../../../../assets/images/shipping.png";
import payment from "../../../../assets/images/payment.png";
import Logo from "../../../ui/Logo";


const FooterDesktop = () => {
  return (
    <footer className="bg-[#f9eddf]">
      <div className="ui-container py-8 text-dark-deep">
        {/* Footer links section */}
        <FooterLinks />

        {/* Shipping and payment info */}
        <div className="p-10 flex gap-8">
          <div>
            <h4 className="text-lg font-semibold">
              Free* and Fast Shipping Worldwide
            </h4>
            <img
              src={shipping}
              alt="Shipping"
              className="w-32 object-contain"
            />
          </div>
          <div>
            <h4 className="text-lg font-semibold">
              Secure Payment and Cash on Delivery
            </h4>
            <img src={payment} alt="Payment" className="w-32 object-contain" />
          </div>
        </div>

        {/* About Unyic section */}
        <div className="flex gap-4 items-start pt-8 border-t border-white px-10">
          <div className="w-96">
            <Logo />
          </div>

          <div>
            <h4 className="text-lg font-semibold">
              Unyic: Discover India&apos;s Most Beautiful Products and Their
              Unique Stories
            </h4>
            <p>
              India wears her beauty in the colorful textiles, breathtaking
              ornaments and inspiring stories that come alive in her streets.
              There is magic in the hands that work the loom, in the eyes that
              pore over a needle, in the brushstrokes that paint life. At Unyic,
              we have begun a fascinating journey, a humble attempt to bring
              India a little closer to the world. Dedicated to creating a unique
              interpretation of age-old crafts, we partner with artisanal
              communities, textile designers, independent artists (and the
              occasional maverick) to showcase a new, contemporary design
              language that comes from India and belongs everywhere on the
              globe. We believe in sharing stories and celebrating how each
              handmade object can come to represent something much bigger than
              itself. Travelling to the colorful corners of this fascinating
              country, we curate unique and exclusive collections that represent
              India&apos;s finest craft-based designs, so that you can savor the
              delightful treasures at leisure, with us. Immerse yourself in the
              beauty of India. Shop for handmade Apparel, jewelry, Home
              furnishing, Home decor & More.
            </p>
          </div>
        </div>

        {/* Copyright notice */}
        <div className="text-center mt-12">
          <p className="text-xs">© 2023 Unyic, All rights Reserved.</p>
        </div>
      </div>
    </footer>
  );
};

export default FooterDesktop;
