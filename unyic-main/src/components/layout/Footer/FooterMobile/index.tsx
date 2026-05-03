import SocialIcons from "../../../ui/SocialIcons";
import FooterFeatures from "./FooterFeatures";
import FooterAccordion from "./FooterAccordion";

const FooterMobile = () => {
  return (
    <footer className="bg-[#f9eddf]">
      <FooterFeatures />

      <div className="text-dark-deep mt-4">
        <div className="ui-container !mt-0 py-5">
          <p className="mb-2">Questions?</p>
          <p className="font-semibold">Mail us at hello@unyic.com</p>
        </div>

        <FooterAccordion />

        {/* Copyright notice */}
        <div className="ui-container !mt-0 bg-light py-4 text-center">
          <p>© {new Date().getFullYear()} Unyic, All rights Reserved.</p>
        </div>

        {/* Social media icons */}
        <div className="ui-container !mt-0 flex items-center justify-center gap-4 text-xl p-5">
          <SocialIcons />
        </div>
      </div>
    </footer>
  );
};

export default FooterMobile;
