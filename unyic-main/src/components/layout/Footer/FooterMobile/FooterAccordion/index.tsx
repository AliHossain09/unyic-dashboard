import FooterAccordionItem from "./FooterAccordionItem";
import footerData from "../../footerData ";

const FooterAccordion = () => {
  return (
    <div className="pb-5 divide-y divide-background-light">
      {footerData.map((item, idx) => (
        <FooterAccordionItem key={idx} item={item} />
      ))}
    </div>
  );
};

export default FooterAccordion;
