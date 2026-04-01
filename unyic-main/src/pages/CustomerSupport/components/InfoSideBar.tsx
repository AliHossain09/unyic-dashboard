import { IoMdTime } from "react-icons/io";
import { IoCallOutline } from "react-icons/io5";
import { MdOutlineMail } from "react-icons/md";
import { BiBadgeCheck } from "react-icons/bi";
import { Link } from "react-router";
import SocialIcons from "../../../components/ui/SocialIcons";

const InfoSideBar = () => {
  return (
    <div className="p-4 bg-light-dark bg-opacity-40 space-y-6 text-sm">
      {/* Corporate Address Section */}
      <div className="space-y-4">
        <h5 className="font-semibold text-base">Corporate Address</h5>
        <p className="customerSupport_addressFull__La9ix">
          665, Pace City II, Sector 37, Gurugram, Haryana - 122002, India.
        </p>
      </div>

      {/* Help Section */}
      <div className="space-y-4">
        <h5 className="font-semibold text-base">Help</h5>
        <div className="flex items-center gap-2">
          <IoCallOutline className="text-lg" />
          <span title="Call our support number">+91-730-5297673</span>
        </div>

        <div className="flex items-center gap-2">
          <IoMdTime className="text-lg mb-5" />
          <p>
            Operational Hours <br />
            9:30 AM to 7:00 PM
          </p>
        </div>

        <div className="flex items-center gap-2">
          <MdOutlineMail className="text-lg" />
          <span title="Email us at hello@unyic.com for assistance">
            hello@unyic.com
          </span>
        </div>

        <div className="customerSupport_supportEmailPrt__BbV6H">
          <span className="sprite customerSupportPageEmail"></span>
          <a href="mailto:"></a>
        </div>
      </div>

      {/* Stay Connected Section */}
      <div className="space-y-4">
        <h5 className="font-semibold text-base">Stay Connected</h5>
        <div className="flex text-xl items-center gap-2">
          <SocialIcons />
        </div>
      </div>

      {/* Current Promotions Section */}
      <div className="space-y-4">
        <h5 className="font-semibold text-base">Current Promotions</h5>

        <Link
          to={"/"}
          title="View Offers and Terms & Conditions"
          className="p-4 flex items-center text-dark border border-dashed border-black"
        >
          <BiBadgeCheck className="text-lg" />
          <span>Offers And T & C</span>
        </Link>
      </div>

      {/* Business Partnership Section */}
      <div className="space-y-4">
        <h5 className="font-semibold text-base">Business Partnership</h5>
        <p>
          Interested in partnering with us, write to <br />
          <span className="font-semibold">
            partnering.unyic@abfrl.adityabirla.com
          </span>
        </p>
      </div>

      {/* Corporate Orders Section */}
      <div className="space-y-4">
        <h5 className="font-semibold text-base">Corporate Orders</h5>
        <p>
          For Bulk / Corporate Orders, Write To <br />
          <span
            title="Contact us via email for business inquiries"
            className="font-semibold"
          >
            b2b@unyic.com
          </span>
          <span
            title="Call us for support: (+91) 9205044554"
            className="font-semibold"
          >
            (+91) 9205044554
          </span>
        </p>
      </div>

      {/* Check Delivery Time Section */}
      <div className="space-y-4">
        <h5 className="font-semibold text-base">Check Delivery time</h5>
        <div className="w-full">
          <input
            type="number"
            className="w-full border rounded py-1 px-2 bg-background-light hide-number-spinner"
            pattern="[0-9]"
            placeholder="Enter 6 digit pincode"
          />
        </div>
      </div>
    </div>
  );
};

export default InfoSideBar;
