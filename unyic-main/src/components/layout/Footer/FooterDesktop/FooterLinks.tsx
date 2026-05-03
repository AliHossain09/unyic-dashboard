import footerData from "../footerData ";
import { Link } from "react-router";
import SocialIcons from "../../../ui/SocialIcons";

const FooterLinks = () => {
  return (
    <div className="flex justify-between gap-8 px-10 pb-10">
      {/* Footer link sections */}
      {footerData.map(({ title, links }) => (
        <div key={title} className="space-y-4">
          <h4 className="text-lg font-semibold">{title}</h4>
          <ul className="space-y-2">
            {links.map((link) => (
              <li key={link.name}>
                <Link to={link.href}>{link.name}</Link>
              </li>
            ))}
          </ul>
        </div>
      ))}

      {/* Social media icons and contact info */}
      <div className="space-y-4">
        <div className="flex items-center gap-4 text-xl">
          <SocialIcons />
        </div>
        <div>
          <p>Questions? Mail us at</p>
          <p>hello@unyic.com</p>
        </div>
      </div>
    </div>
  );
};

export default FooterLinks;
